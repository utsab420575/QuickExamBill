<?php

namespace App\Http\Controllers;

use App\Models\RateAmount;
use App\Models\RateAssign;
use App\Models\RateHead;
use App\Models\Teacher;
use App\Services\ApiData;
use App\Services\LocalData;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class CommitteeInputController extends Controller
{
    //regular session list
    public function regularSessionShow(){
        $sessions=ApiData::getRegularSessions();
        if($sessions === null) {
            return redirect()->back()->with([
                'message' => 'Session Import Failed',
                'alert-type' => 'error',
            ]);
        }
        return view('committee_input.session_view.regular_session_list',compact('sessions'));
    }



    public function regularSessionForm(Request $request)
    {

        //this session id got from session list blade
        $sid=$request->sid;
        $session_info=ApiData::getSessionInfo($sid);
        //filter by department
        $order = ['Arch', 'CE', 'ChE', 'Chem','CSE','EEE','FE','HSS','IPE','Math','ME','MME','Phy','TE']; // Custom order of departments

        //this is for selection box with search
        $teachers = Teacher::with('user', 'designation', 'department')
            ->whereHas('department', function ($query) use ($order) {
                $query->whereIn('shortname', $order);
            })
            ->join('departments', 'teachers.department_id', '=', 'departments.id')
            ->orderByRaw("FIELD(departments.shortname, '" . implode("','", $order) . "')")
            ->select('teachers.*') // Select only teacher fields to avoid conflict
            ->get();

        //return $teachers;
        // Group by department short name
        $groupedTeachers = $teachers->groupBy(function ($teacher) {
            return $teacher->department->fullname ?? 'Unknown';
        });

        // Move 'Arch' to the beginning
        $groupedTeachers = $groupedTeachers->sortBy(function ($group, $key) {
            return $key === 'Architecture' ? 0 : 1;
        });
        //return $groupedTeachers;


        //all theory course with teacher
        $all_course_with_teacher = ApiData::getSessionWiseTheoryCoursesRegular($sid);
        //return $all_course_with_teacher;

        //no need to call again for class test(class test for theory course)
        // $all_course_with_class_test_teacher=ApiData::getSessionWiseTheoryCourses(sid);
        //all sessional course with teacher
        $all_sessional_course_with_teacher = ApiData::getSessionWiseSessionalCourses($sid);
        //all theory sessional courses
        $all_theory_sessional_courses_with_student_count = ApiData::getSessionWiseTheorySessionalCourses($sid);
        //all student advisor in specific student
        $all_advisor_with_student_count = ApiData::getSessionWiseStudentAdvisor($sid);
        //active coordinator(we will give it internal database)
        //$co_ordinator_arch = ApiData::getCoOrdinator();


        // return response()->json(['$all_course_with_teacher'=>$all_course_with_teacher]);
        /*return response()->json(['head'=>$all_course_with_class_test_teacher]);*/
        return view('committee_input.regular_form.regular_session_form')
            ->with('sid',$sid)
            /*->with('teacher_head', $teacher_head)*/
            /*  ->with('teacher_coordinator', $teacher_coordinator)*/
            ->with('session_info', $session_info)
            ->with('groupedTeachers', $groupedTeachers)
            ->with('teachers', $teachers)
            ->with('all_course_with_teacher', $all_course_with_teacher)
            ->with('all_course_with_class_test_teacher', $all_course_with_teacher)
            ->with('all_sessional_course_with_teacher', $all_sessional_course_with_teacher)
            ->with('all_theory_sessional_courses_with_student_count', $all_theory_sessional_courses_with_student_count)
            ->with('all_advisor_with_student_count', $all_advisor_with_student_count);
    }


    //Examination Moderation Committee
    public function storeExaminationModerationCommittee(Request $request)
    {
        // Log all request data with a custom message
        Log::info('Examination moderation committee called', [
            'request_data' => $request->all()  // Log all input data from the request
        ]);
        $teacherIds = $request->input('moderation_committee_teacher_ids'); // array
        $amounts = $request->input('moderation_committee_amounts');        // array (indexed)
        $sessionId = $request->sid;
        $min_rate=$request->moderation_committee_min_rate;
        $max_rate=$request->moderation_committee_max_rate;
        $exam_type=1;

        Log::info('teacherId',$teacherIds);
        Log::info('amounts',$amounts);
        Log::info('sessionId: ' . $sessionId);

        // Step 1: Validate teacher inputs
        if (empty($teacherIds) || !is_array($teacherIds) || count($teacherIds) !== count($amounts)) {
            return response()->json([
                'message' => 'Invalid data submitted. Please select teachers and their respective student count.'
            ], 422);
        }


        Log::info('pass out1');
        // Step 2: Check for duplicates
        if (count($teacherIds) !== count(array_unique($teacherIds))) {
            return response()->json([
                'message' => 'Duplicate teacher selection detected. Please choose unique teachers.'
            ], 422);
        }


        // ✅ Step 3: Check if each amount is within min and max rate
        foreach ($amounts as $index => $amount) {
            if (!is_numeric($amount)) {
                return response()->json([
                    'message' => "Invalid amount format for teacher at index {$index}."
                ], 422);
            }

            if ($amount < $min_rate || $amount > $max_rate) {
                return response()->json([
                    'message' => "Amount for teacher at position " . ($index + 1) . " must be between {$min_rate} and {$max_rate}."
                ], 422);
            }
        }


        Log::info('pass out2');
        DB::beginTransaction();

        try {
            // Step 3: Ensure RateHead exists
            $rateHead = RateHead::where('order_no', 1)->first();
            Log::info('rateHead', $rateHead ? $rateHead->toArray() : ['rateHead' => null]);
            if (!$rateHead) {
                $rateHead = new RateHead();
                $rateHead->head = 'Moderation';
                $rateHead->order_no = 1;
                $rateHead->dist_type = 'Individual';
                $rateHead->enable_min = 1;
                $rateHead->enable_max = 1;
                $rateHead->is_course = 0;
                $rateHead->is_student_count = 0;
                $rateHead->marge_with = null;
                $rateHead->status = 1;
                $rateHead->save();
                if ($rateHead->save()) {
                    Log::info('✅ New RateHead created', $rateHead->toArray());
                } else {
                    Log::error('❌ Failed to save RateHead');
                }
            }

            //ensure session exist
            $session_info = LocalData::getOrCreateRegularSession($sessionId,$exam_type);


            // Step 4: Ensure  RateAmount exists(Rate Amount Exist for Rate Head=1)
            $rateAmount = RateAmount::where('rate_head_id', $rateHead->id)
                ->where('session_id', $session_info->id)
                ->where('exam_type_id',$exam_type)
                ->first();

            Log::info('rateAmount', $rateAmount ? $rateAmount->toArray() : ['rateAmount' => null]);
            if (!$rateAmount) {
                $rateAmount = new RateAmount();
                $rateAmount->default_rate = 0;
                $rateAmount->min_rate = $min_rate;
                $rateAmount->max_rate = $max_rate;
                $rateAmount->session_id = $session_info->id;
                $rateAmount->rate_head_id = $rateHead->id;
                $rateAmount->exam_type_id = $exam_type;
                $rateAmount->saved = 1;
                if ($rateAmount->save()) {
                    Log::info('✅ New RateAmount created', $rateAmount->toArray());
                } else {
                    Log::error('❌ Failed to save RateHead');
                }
            }

            // Step 5: Loop and store teacher-wise rate_assign
            foreach ($teacherIds as $index => $teacherId) {
                $amount = isset($amounts[$index]) ? intval($amounts[$index]) : 0;

                if ($amount <= 0) {
                    //  DB::rollBack();
                    return response()->json([
                        'message' => "Invalid amount for teacher ID: $teacherId."
                    ], 422);
                }

                RateAssign::create([
                    'teacher_id' => $teacherId,
                    'rate_head_id' => $rateHead->id,
                    'session_id' => $session_info->id,
                    'exam_type_id'=>$exam_type,
                    'no_of_items' => 0,
                    'total_amount' => $amount,
                ]);
            }

            DB::commit();

            return response()->json([
                'message' => 'Moderation committee data stored successfully.'
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::info($e->getMessage());
            return response()->json([
                'message' => 'Something went wrong.',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    //store PaperSetter/Examiner
    public function storeExaminerPaperSetter(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'examiner_rate_per_script' => 'required|numeric|min:1',
            'examiner_min_rate' => 'required|numeric|min:1',
            'paper_setter_rate' => 'required|numeric|min:1',
            'paper_setter_ids' => 'required|array',
            'examiner_ids' => 'required|array',
            'no_of_script' => 'required|array',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validation error.',
                'errors' => $validator->errors()
            ], 422);
        }


        $paperSetterData = $request->input('paper_setter_ids', []);
        $examinerData = $request->input('examiner_ids', []);
        $noOfScripts = $request->input('no_of_script', []);
        $script_rate=$request->examiner_rate_per_script;
        $examiner_min_rate=$request->examiner_min_rate;
        $paper_setter_rate=$request->paper_setter_rate;
        $sessionId = $request->sid;
        $exam_type=1;
        // ✅ Log all data
        Log::info('🔍 Incoming Examiner & Paper Setter Submission', [
            'paper_setter_ids' => $paperSetterData,
            'examiner_ids' => $examinerData,
            'no_of_script' => $noOfScripts,
            'examiner_rate_per_script' => $script_rate,
            'examiner_min_rate' => $examiner_min_rate,
            'paper_setter_rate' => $paper_setter_rate,
            'session_id' => $sessionId,
            'exam_type' => $exam_type,
        ]);

        try {
            DB::beginTransaction();

            // RateHead 2 - Paper Setters
            $rateHead_2 = RateHead::where('order_no', 2)->first();
            Log::info('rateHead2', $rateHead_2 ? $rateHead_2->toArray() : ['rateHead2' => null]);
            if (!$rateHead_2) {
                $rateHead_2 = new RateHead();
                $rateHead_2->head = 'Paper Setters';
                $rateHead_2->order_no = 2;
                $rateHead_2->dist_type = 'Individual';
                $rateHead_2->enable_min = 0;
                $rateHead_2->enable_max = 0;
                $rateHead_2->is_course = 1;
                $rateHead_2->is_student_count = 0;
                $rateHead_2->marge_with = null;
                $rateHead_2->status = 1;
                if ($rateHead_2->save()) {
                    Log::info('✅ New RateHead created', $rateHead_2->toArray());
                } else {
                    Log::error('❌ Failed to save RateHead');
                }
            }

            // RateHead 3 - Examiner
            $rateHead_3 = RateHead::where('order_no', 3)->first();
            Log::info('rateHead3', $rateHead_2 ? $rateHead_2->toArray() : ['rateHead3' => null]);
            if (!$rateHead_3) {
                $rateHead_3 = new RateHead();
                $rateHead_3->head = 'Examiner';
                $rateHead_3->order_no = 3;
                $rateHead_3->dist_type = 'Share';
                $rateHead_3->enable_min = 1;
                $rateHead_3->enable_max = 0;
                $rateHead_3->is_course = 1;
                $rateHead_3->is_student_count = 1;
                $rateHead_3->marge_with = null;
                $rateHead_3->status = 1;
                if ($rateHead_3->save()) {
                    Log::info('✅ New RateHead3 created', $rateHead_3->toArray());
                } else {
                    Log::error('❌ Failed to save RateHead3');
                }
            }

            // Ensure Session exists
            $session_info = LocalData::getOrCreateRegularSession($sessionId,$exam_type);

            // RateAmount for RateHead 2
            $rateAmount_2 = RateAmount::where('rate_head_id', $rateHead_2->id)
                ->where('session_id', $session_info->id)
                ->where('exam_type_id',$exam_type)
                ->first();

            Log::info('rateAmount2', $rateAmount_2 ? $rateAmount_2->toArray() : ['rateAmount_2' => null]);
            if (!$rateAmount_2) {
                $rateAmount_2 = new RateAmount();
                $rateAmount_2->default_rate = $paper_setter_rate;
                //null for min_rate , max_rate
                $rateAmount_2->session_id = $session_info->id;
                $rateAmount_2->rate_head_id = $rateHead_2->id;
                $rateAmount_2->exam_type_id = $exam_type;
                $rateAmount_2->saved = 1;
                if ($rateAmount_2->save()) {
                    Log::info('✅ New RateAmount created', $rateAmount_2->toArray());
                } else {
                    Log::error('❌ Failed to save RateAmount');
                }
            }

            // RateAmount for RateHead 3
            $rateAmount_3 = RateAmount::where('rate_head_id', $rateHead_3->id)
                ->where('session_id', $session_info->id)
                ->first();

            if (!$rateAmount_3) {
                $rateAmount_3 = new RateAmount();
                $rateAmount_3->default_rate = $script_rate;
                $rateAmount_3->min_rate = $examiner_min_rate;
                //max rate null(not defined)
                $rateAmount_3->session_id = $session_info->id;
                $rateAmount_3->rate_head_id = $rateHead_3->id;
                $rateAmount_3->exam_type_id = $exam_type;
                $rateAmount_3->saved = 1;
                if ($rateAmount_3->save()) {
                    Log::info('✅ New RateAmount created', $rateAmount_3->toArray());
                } else {
                    Log::error('❌ Failed to save RateHead');
                }
            }


            /*"paper_setters":
               {
                    "1": ["110", "120"],
                    "4": ["120", "140"],
                }*/
            //here $courseId is 1,4
            //$teacherIds [110, 120] for 1
            //$teacherIds [120, 140] for 4
            // Store Paper Setters
            foreach ($paperSetterData as $courseId => $teacherIds) {
                //loop for $teacherIds [120, 140] $teacherId=120,$teacherId=140
                foreach ($teacherIds as $teacherId) {
                    $rateAssign = new RateAssign();
                    $rateAssign->teacher_id = $teacherId;
                    $rateAssign->rate_head_id = $rateHead_2->id;
                    $rateAssign->session_id = $session_info->id;
                    $rateAssign->no_of_items = 0;
                    $rateAssign->total_amount = $paper_setter_rate;
                    $rateAssign->exam_type_id = $exam_type;




                    // Add hidden course-related data
                    $rateAssign->course_code = $request->input("courseno.$courseId");
                    $rateAssign->course_name = $request->input("coursetitle.$courseId");
                    $rateAssign->total_students = $request->input("registered_students_count.$courseId");
                    $rateAssign->total_teachers = $request->input("teacher_count.$courseId");



                    // ✅ Log before saving
                    Log::info('📄 Saving Paper Setter Assignment', [
                        'course_id' => $courseId,
                        'teacher_id' => $teacherId,
                        'course_code' => $rateAssign->course_code,
                        'course_name' => $rateAssign->course_name,
                        'total_students' => $rateAssign->total_students,
                        'total_teacher' => $rateAssign->total_teacher,
                        'rate_head_id' => $rateAssign->rate_head_id,
                        'session_id' => $rateAssign->session_id,
                        'exam_type_id' => $rateAssign->exam_type_id,
                        'total_amount' => $rateAssign->total_amount,
                    ]);
                    if ($rateAssign->save()) {
                        Log::info('✅ RateAssign saved successfully', $rateAssign->toArray());
                    } else {
                        Log::error('❌ Failed to save RateAssign - unknown error', $rateAssign->toArray());
                    }
                }
            }

            // Store Examiners
            foreach ($examinerData as $courseId => $teacherIds) {
                $total_input_students = $noOfScripts[$courseId] ?? 0;
                $no_of_scripts = $noOfScripts[$courseId] ?? 0;

                $teacherCount = count($teacherIds);

                //hidden input
                $courseno = $request->input("courseno.$courseId");
                $coursetitle = $request->input("coursetitle.$courseId");
                $registered_students_count = $request->input("registered_students_count.$courseId");
                $teacher_count = $request->input("teacher_count.$courseId");


                Log::info('📘 Examiner Course-wise Input Data', [
                    'course_id' => $courseId,
                    'teacher_ids' => $teacherIds,
                    'total_input_students' => $total_input_students,
                    'no_of_scripts' => $no_of_scripts,
                    'teacher_count' => $teacherCount,
                    'course_code' => $courseno,
                    'course_title' => $coursetitle,
                    'registered_students_count' => $registered_students_count,
                    'hidden_teacher_count' => $teacher_count,
                ]);

                if ($teacherCount > 0) {
                    $no_of_scripts = $no_of_scripts / $teacherCount;
                } else {
                    $no_of_scripts = 0;
                }
                foreach ($teacherIds as $teacherId) {
                    $total_amount = $no_of_scripts * $rateAmount_3->default_rate;
                    if ($total_amount < $rateAmount_3->min_rate) {
                        $total_amount = $rateAmount_3->min_rate;
                    }


                    // ✅ Log before saving
                    Log::info('📄 Saving Examiner Data', [
                        'course_id' => $courseId,
                        'teacher_id' => $teacherId,
                        'course_code' => $courseno,
                        'course_name' => $coursetitle,
                        'total_students' => $total_input_students,
                        'total_teacher' => $teacher_count,
                        'rate_head_id' => $rateHead_3->id,
                        'session_id' => $session_info->id,
                        'exam_type_id' => $exam_type,
                        'total_amount' => $total_amount,
                    ]);


                    //another way for insert
                    RateAssign::create([
                        'teacher_id'   => $teacherId,
                        'rate_head_id' => $rateHead_3->id,
                        'session_id'   => $session_info->id,
                        'no_of_items'  => $no_of_scripts,
                        'total_amount' => $total_amount,
                        'exam_type_id'=>$exam_type,

                        // Add hidden course-related data
                        'course_code'  => $courseno,
                        'course_name'   => $coursetitle,
                        'total_students' => $total_input_students,
                        'total_teachers'  => $teacher_count,
                    ]);
                }
            }

            DB::commit();
            Log::info('✅ All examiner and paper setter data saved successfully.', [
                'session_id' => $session_info->id,
                'rate_heads' => [
                    'paper_setter' => $rateHead_2->id,
                    'examiner' => $rateHead_3->id,
                ]
            ]);


            return response()->json([
                'message' => 'Examiner and Paper Setter data saved successfully.'
            ]);

        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json([
                'message' => 'An error occurred while saving data.',
                'error'   => $e->getMessage()
            ], 500);
        }
    }
}


