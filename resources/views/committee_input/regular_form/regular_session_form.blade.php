@extends('layouts.app')
@section('styles')
    <style>
        #table-list-of-examination-committee td {
            transition: background-color 0.6s ease-in-out, opacity 0.6s ease-in-out;
        }

        .fade-green {
            background-color: #68a17a !important;
            opacity: 1;
        }

        .fade-out {
            opacity: 0.3;
        }

    </style>
    @stack('styles')

@endsection
@section('content')
    <section role="main" class="content-body">
        <header class="page-header">
            <h2>Regular Session All Form(Session:{{$session_info['session']}}-{{$session_info['year']}}
                /{{$session_info['semester']}})</h2>
            <div class="right-wrapper text-end">
                <ol class="breadcrumbs">
                    <li>
                        <a href="{{route('dashboard')}}">
                            <i class="bx bx-home-alt"></i>
                        </a>
                    </li>
                    <li><span>Committee Input</span></li>
                    <li><span>Regular Session</span></li>
                </ol>
                <a class="sidebar-right-toggle" data-open="sidebar-right"><i class="fas fa-chevron-left"></i></a>
            </div>
        </header>
        <!-- start: page -->


        @php
            use App\Models\RateAmount;
            use App\Models\RateAssign;
            use App\Models\RateHead;
            use App\Models\Session;
            use App\Models\ExamType;

            // Initialize variables with default values
            $mc_min_rate = null;
            $mc_max_rate = null;
            $paper_setter_rate = null;
            $examiner_rate_per_script = null;
            $examiner_min_rate = null;
            $savedModerationAssigns = collect();  // Default to empty collection
            $savedRateAssignPaperSetter = collect();  // Default to empty collection
            $savedRateAssignExaminer = collect();  // Default to empty collection
            $savedRateAssignClassTest = collect();  // Default to empty collection
            $savedRateAssignSessionalCourseTeacher = collect();  // Default to empty collection
            $savedRateAssignScrutinizers = collect();  // Default to empty collection
            $savedRateAssignSessionalGradeSheet = collect();  // Default to empty collection
            $savedRateAssignScrutinizersTheoryGradeSheet = collect();  // Default to empty collection
            $savedRateAssignScrutinizersSessionalGradeSheet = collect();  // Default to empty collection
            $savedRateAssignPreparedComputerizedResult = collect();  // Default to empty collection
            $savedRateAssignVerifiedComputerizedGradeSheet = collect();  // Default to empty collection
            $savedRateAssignStencilCuttingCommittee = collect();  // Default to empty collection
            $savedRateAssignPrintingQuestion = collect();  // Default to empty collection
            $savedRateAssignComparisonCommittee = collect();  // Default to empty collection

            $savedRateAssignAdvisorStudent = collect();  // Default to empty collection

            $savedRateAssignVerifiedFinalGraduationResult = collect();  // Default to empty collection
            $savedRateAssignConductedCentralOralExam = collect();  // Default to empty collection
            $savedRateAssignInvolvedSurvey = collect();  // Default to empty collection
            $savedRateAssignConductedPreliminaryViva = collect();  // Default to empty collection
            $savedRateAssignExaminedThesisProject = collect();  // Default to empty collection
            $savedRateAssignConductedOralExamination = collect();  // Default to empty collection
            $savedRateAssignSupervisedThesisProject = collect();  // Default to empty collection
            $savedRateAssignHonorariumCoordinator = collect();  // Default to empty collection
            $savedRateAssignHonorariumChairman = collect();  // Default to empty collection















           //$exam_type,session_info receive from controller
            // Ensure session_info is not null before proceeding
            if ($session_info) {
                    // Moderation Committee
                    $rateHead = RateHead::where('order_no', 1)->first();
                    if ($rateHead) {
                        $mc_data = RateAmount::where('exam_type_id', $exam_type)
                            ->where('rate_head_id', $rateHead->id)
                            ->where('session_id', $session_info->id)
                            ->first();

                        // Check if mc_data is found before accessing properties
                        $mc_min_rate = $mc_data ? $mc_data->min_rate : null;
                        $mc_max_rate = $mc_data ? $mc_data->max_rate : null;
                    }

                    // Paper Setter Examiner
                    $rateHeadPaperSetter = RateHead::where('order_no', 2)->first();
                    $rateHeadExaminer = RateHead::where('order_no', 3)->first();

                    if ($rateHeadPaperSetter && $rateHeadExaminer) {
                        $ps_data = RateAmount::where('exam_type_id', $exam_type)
                            ->where('rate_head_id', $rateHeadPaperSetter->id)
                            ->where('session_id', $session_info->id)
                            ->first();

                        $examiner_data = RateAmount::where('exam_type_id', $exam_type)
                            ->where('rate_head_id', $rateHeadExaminer->id)
                            ->where('session_id', $session_info->id)
                            ->first();

                        // Check if ps_data and examiner_data are found before accessing properties
                        $paper_setter_rate = $ps_data ? $ps_data->default_rate : null;
                        $examiner_rate_per_script = $examiner_data ? $examiner_data->default_rate : null;
                        $examiner_min_rate = $examiner_data ? $examiner_data->min_rate : null;
                    }

                    // For Moderation Committee (Ensure session_info, rateHead, and exam_type are not null)
                    $savedModerationAssigns = ($session_info && $rateHead && $exam_type)
                        ? RateAssign::getModerationCommitteeData($session_info->id, $exam_type, $rateHead->id)
                        : collect(); // fallback to empty collection if any value is null


                    // For Paper Setter Examiner (Ensure all needed data exists)
                    if ($rateHeadPaperSetter && $rateHeadExaminer) {
                        $savedRateAssignPaperSetter = RateAssign::getTeacherWithCourse(
                            $session_info->id,
                            $exam_type,
                            $rateHeadPaperSetter->id
                        );

                        $savedRateAssignExaminer = RateAssign::getTeacherWithCourse(
                            $session_info->id,
                            $exam_type,
                            $rateHeadExaminer->id
                        );
                    }

                    //For Class Test
                    $rateHeadCT = RateHead::where('order_no', 4)->first();
                    if($rateHeadCT){
                        $savedRateAssignClassTest = RateAssign::getTeacherWithCourse(
                            $session_info->id,
                            $exam_type,
                            $rateHeadCT->id
                        );
                    }


                    //For Sessional Course Teacher
                    $rateHeadSCT = RateHead::where('order_no', 5)->first();
                    if($rateHeadSCT){
                        $savedRateAssignSessionalCourseTeacher = RateAssign::getTeacherWithCourse(
                            $session_info->id,
                            $exam_type,
                            $rateHeadSCT->id
                        );
                    }

                    //For Sessional Course Teacher
                    $rateHeadSCT = RateHead::where('order_no', 5)->first();
                    if($rateHeadSCT){
                        $savedRateAssignSessionalCourseTeacher = RateAssign::getTeacherWithCourse(
                            $session_info->id,
                            $exam_type,
                            $rateHeadSCT->id
                        );
                    }

                     //For Scrutinizers
                    $rateHeadScrutinizers = RateHead::where('order_no', 9)->first();
                    if($rateHeadScrutinizers){
                        $savedRateAssignScrutinizers = RateAssign::getTeacherWithCourse(
                            $session_info->id,
                            $exam_type,
                            $rateHeadScrutinizers->id
                        );
                    }

                    //For Scrutinizers
                    $rateTheoryGradeSheet = RateHead::where('order_no', '=','8.a')->first();
                    if($rateTheoryGradeSheet){
                        $savedRateAssignTheoryGradeSheet = RateAssign::getTeacherWithCourse(
                            $session_info->id,
                            $exam_type,
                            $rateTheoryGradeSheet->id
                        );
                    }

                    //For SessionalGradeShee
                    $rateSessionalGradeSheet = RateHead::where('order_no', '=','8.b')->first();
                    if($rateSessionalGradeSheet){
                        $savedRateAssignSessionalGradeSheet = RateAssign::getTeacherWithCourse(
                            $session_info->id,
                            $exam_type,
                            $rateSessionalGradeSheet->id
                        );
                    }

                     //For ScrutinizersTheoryGradeSheet
                    $rateScrutinizersTheoryGradeSheet = RateHead::where('order_no', '=','10.a')->first();
                    if($rateScrutinizersTheoryGradeSheet){
                        $savedRateAssignScrutinizersTheoryGradeSheet = RateAssign::getTeacherWithCourse(
                            $session_info->id,
                            $exam_type,
                            $rateScrutinizersTheoryGradeSheet->id
                        );
                    }

                    //For ScrutinizersTheoryGradeSheet
                    $rateScrutinizersSessionalGradeSheet = RateHead::where('order_no', '=','10.b')->first();
                    if($rateScrutinizersSessionalGradeSheet){
                        $savedRateAssignScrutinizersSessionalGradeSheet = RateAssign::getTeacherWithCourse(
                            $session_info->id,
                            $exam_type,
                            $rateScrutinizersSessionalGradeSheet->id
                        );
                    }

                    //For PreparedComputerizedResult
                    $ratePreparedComputerizedResult = RateHead::where('order_no', '=','8.d')->first();
                    if($ratePreparedComputerizedResult){
                        $savedRateAssignPreparedComputerizedResult = RateAssign::getTeacherWithCourse(
                            $session_info->id,
                            $exam_type,
                            $ratePreparedComputerizedResult->id
                        );
                    }

                    //For VerifiedComputerizedGradeSheet
                    $rateVerifiedComputerizedGradeSheet = RateHead::where('order_no', '=','8.c')->first();
                    if($rateVerifiedComputerizedGradeSheet){
                        $savedRateAssignVerifiedComputerizedGradeSheet = RateAssign::getTeachersFromCommittee(
                            $session_info->id,
                            $exam_type,
                            $rateVerifiedComputerizedGradeSheet->id
                        );
                    }

                 //For StencilCuttingCommittee
                $rateStencilCuttingCommittee = RateHead::where('order_no', '=','12.a')->first();
                if($rateStencilCuttingCommittee){
                    $savedRateAssignStencilCuttingCommittee = RateAssign::getTeachersFromCommittee(
                        $session_info->id,
                        $exam_type,
                        $rateStencilCuttingCommittee->id
                    );
                }


                //For PrintingQuestion
                $ratePrintingQuestion = RateHead::where('order_no', '=','12.b')->first();
                if($ratePrintingQuestion){
                    $savedRateAssignPrintingQuestion = RateAssign::getTeachersFromCommittee(
                        $session_info->id,
                        $exam_type,
                        $ratePrintingQuestion->id
                    );
                }

                //For AdvisorStudent
                $rateAdvisorStudent = RateHead::where('order_no', '=','13')->first();
                if($rateAdvisorStudent){
                    $savedRateAssignAdvisorStudent = RateAssign::getTeachersFromCommittee(
                        $session_info->id,
                        $exam_type,
                        $rateAdvisorStudent->id
                    );
                }




                //For ComparisonCommittee
                $rateComparisonCommittee = RateHead::where('order_no', '=','11')->first();
                if($rateComparisonCommittee){
                    $savedRateAssignComparisonCommittee = RateAssign::getTeachersFromCommittee(
                        $session_info->id,
                        $exam_type,
                        $rateComparisonCommittee->id
                    );
                }


                //For VerifiedFinalGraduationResult
                $rateVerifiedFinalGraduationResult = RateHead::where('order_no', '=','16')->first();
                if($rateVerifiedFinalGraduationResult){
                    $savedRateAssignVerifiedFinalGraduationResult = RateAssign::getTeachersFromCommittee(
                        $session_info->id,
                        $exam_type,
                        $rateVerifiedFinalGraduationResult->id
                    );
                }

                 //For VerifiedFinalGraduationResult
                $rateConductedCentralOralExam = RateHead::where('order_no', '=','7.e')->first();
                if($rateConductedCentralOralExam){
                      $savedRateAssignConductedCentralOralExam = RateAssign::getTeachersFromCommittee(
                        $session_info->id,
                        $exam_type,
                        $rateConductedCentralOralExam->id
                    );
                }

                 //For InvolvedSurvey
                $rateInvolvedSurvey = RateHead::where('order_no', '=','7.f')->first();
                if($rateInvolvedSurvey){
                      $savedRateAssignInvolvedSurvey = RateAssign::getTeachersFromCommittee(
                        $session_info->id,
                        $exam_type,
                        $rateInvolvedSurvey->id
                    );
                }

                //For ConductedPreliminaryViva
                $rateConductedPreliminaryViva = RateHead::where('order_no', '=','6.c')->first();
                if($rateConductedPreliminaryViva){
                      $savedRateAssignConductedPreliminaryViva = RateAssign::getTeachersFromCommittee(
                        $session_info->id,
                        $exam_type,
                        $rateConductedPreliminaryViva->id
                    );
                }


                //For ExaminedThesisProject
                $rateExaminedThesisProject = RateHead::where('order_no', '=','6.a')->first();
                if($rateExaminedThesisProject){
                      $savedRateAssignExaminedThesisProject = RateAssign::getTeachersFromCommittee(
                        $session_info->id,
                        $exam_type,
                        $rateExaminedThesisProject->id
                    );
                }

                //For ExaminedThesisProject
                $rateConductedOralExamination = RateHead::where('order_no', '=','6.d')->first();
                if($rateConductedOralExamination){
                      $savedRateAssignConductedOralExamination = RateAssign::getTeachersFromCommittee(
                        $session_info->id,
                        $exam_type,
                        $rateConductedOralExamination->id
                    );
                }

                //For ExaminedThesisProject
                $rateSupervisedThesisProject = RateHead::where('order_no', '=','6.b')->first();
                if($rateSupervisedThesisProject){
                      $savedRateAssignSupervisedThesisProject = RateAssign::getTeachersFromCommittee(
                        $session_info->id,
                        $exam_type,
                        $rateSupervisedThesisProject->id
                    );
                }

                //For ExaminedThesisProject
                $rateHonorariumCoordinator = RateHead::where('order_no', '=','14')->first();
                if($rateHonorariumCoordinator){
                      $savedRateAssignHonorariumCoordinator = RateAssign::getTeachersFromCommittee(
                        $session_info->id,
                        $exam_type,
                        $rateHonorariumCoordinator->id
                    );
                }

                //For ExaminedThesisProject
                $rateHonorariumChairman = RateHead::where('order_no', '=','15')->first();
                if($rateHonorariumChairman){
                      $savedRateAssignHonorariumChairman = RateAssign::getTeachersFromCommittee(
                        $session_info->id,
                        $exam_type,
                        $rateHonorariumChairman->id
                    );
                }











            }
        @endphp

        {{--Examination Moderation Committee--}}
        @include('committee_input.patritals.regular.list_moderation_committe')




        {{-- 2,3 order are combined in a blade paper setter,examiner--}}
        @if($session_info->year==6&& $session_info->semester==3)
            @include('committee_input.patritals.regular.list_paper_setter_examineer_6_3')
        @else
            @include('committee_input.patritals.regular.list_paper_setter_examineer')
        @endif


        @if($session_info->year!=6&& $session_info->semester!=3)
            @include('committee_input.patritals.regular.list_class_test_teacher')
        @endif


        @if($session_info->year!=6&& $session_info->semester!=3)
            @include('committee_input.patritals.regular.list_sessional_course_teacher')
        @endif



        @include('committee_input.patritals.regular.list_scrutinizers')



        @include('committee_input.patritals.regular.list_preparation_theory_grade_sheet')



        @if($session_info->year!=6&& $session_info->semester!=3)
            @include('committee_input.patritals.regular.list_preparation_sessional_grade_sheet')
        @endif



        @include('committee_input.patritals.regular.list_scrutinizing_theory_grade_sheet')




        @if($session_info->year!=6&& $session_info->semester!=3)
            @include('committee_input.patritals.regular.list_scrutinizing_sessional_grade_sheet')
        @endif



        @include('committee_input.patritals.regular.list_prepared_computerized_result')



        @include('committee_input.patritals.regular.list_verified_computerized_grade_sheet')



        @include('committee_input.patritals.regular.list_stencil_cutting_question_paper')


        @include('committee_input.patritals.regular.list_printing_question_paper')



        @include('committee_input.patritals.regular.list_comparison_question_paper')


       {{-- order-13:not done--}}
        @include('committee_input.patritals.regular.list_advisor_student')

        {{--order 16--}}
        @include('committee_input.patritals.regular.list_verified_final_graduation_result')



        {{-- order-7.e--}}
         @if($session_info->year!=6&& $session_info->semester!=3)
             @include('committee_input.patritals.regular.list_conducted_central_oral_examination')
         @endif


        {{-- order-7.f--}}
           @if($session_info->year!=6&& $session_info->semester!=3)
               @include('committee_input.patritals.regular.list_involved_survey')
           @endif


        {{-- order-6.c--}}
        @if($session_info->year!=6&& $session_info->semester!=3)
            @include('committee_input.patritals.regular.list_conducted_priliminary_viva')
        @endif


        {{-- order-6.a--}}
         @if($session_info->year!=6&& $session_info->semester!=3)
             @include('committee_input.patritals.regular.list_examined_thesis_project')
         @endif


        {{-- order-6.d--}}
           @if($session_info->year!=6&& $session_info->semester!=3)
               @include('committee_input.patritals.regular.list_conducted_oral_examination')
           @endif


        {{-- order-6.b--}}
        @if($session_info->year!=6&& $session_info->semester!=3)
            @include('committee_input.patritals.regular.list_supervised_thesis_project')
        @endif


        {{-- order-14--}}
        @include('committee_input.patritals.regular.list_honorarium_coordinator')


        {{-- order-15--}}
        @include('committee_input.patritals.regular.list_honorarium_chairman')



        {{--@include('committee_input.patritals.regular.list_moderation_committe_test')--}}

        <!-- end: page -->
    </section>

@endsection
<!-- Add Script Data(You can write it any javascript file and than just import this js) -->
<!-- this will be fire for any 'delete' class element[const target = event.target.closest('.delete');] -->
@push('scripts')

@endpush


