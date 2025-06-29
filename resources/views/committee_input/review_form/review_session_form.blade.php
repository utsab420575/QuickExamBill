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
            <h2>Review Session All Form(Session:{{$session_info['session']}}-{{$session_info['year']}}/{{$session_info['semester']}})</h2>
            <div class="right-wrapper text-end">
                <ol class="breadcrumbs">
                    <li>
                        <a href="index.html">
                            <i class="bx bx-home-alt"></i>
                        </a>
                    </li>
                    <li><span>Committee Input</span></li>
                    <li><span>Review Session Session</span></li>
                </ol>
                <a class="sidebar-right-toggle" data-open="sidebar-right"><i class="fas fa-chevron-left"></i></a>
            </div>
        </header>
        <!-- start: page -->

        {{--@php
            use App\Models\RateAmount;
            $session = \App\Models\Session::where('ugr_id', $sid)->where('exam_type_id', 1)->first();
            $session_info=(object)$session_info;
        @endphp--}}
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

            $scrutinizer_per_script_rate=null;
            $scrutinizer_min_rate=null;


            $theory_grade_sheet_per_subject_rate=null;

            $scrunizing_theory_grade_sheet_per_subject_rate=null;


            $stencill_cutting_per_stencil_rate=null;

            $print_question_paper_rate=null;

            $comparison_rate=null;

            $honorium_chairman=null;

            $savedModerationAssigns = collect();  // Default to empty collection
            $savedRateAssignPaperSetter = collect();  // Default to empty collection
            $savedRateAssignExaminer = collect();  // Default to empty collection
             $savedRateAssignScrutinizers = collect();  // Default to empty collection


            if ($session_info)
            {
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

                     //For Scrutinizers
                    $rateHeadScrutinizers = RateHead::where('order_no', 9)->first();
                    if($rateHeadScrutinizers){
                        $savedRateAssignScrutinizers = RateAssign::getTeacherWithCourse(
                            $session_info->id,
                            $exam_type,
                            $rateHeadScrutinizers->id
                        );

                         $ScrutinizersData = RateAmount::where('exam_type_id', $exam_type)
                        ->where('rate_head_id', $rateHeadScrutinizers->id)
                        ->where('session_id', $session_info->id)
                        ->first();

                      $scrutinizer_per_script_rate=$ScrutinizersData?->default_rate;
                      $scrutinizer_min_rate=$ScrutinizersData?->min_rate;
                    }

                     //For TheoryGradeSheet
                    $rateTheoryGradeSheet = RateHead::where('order_no', '=','8.a')->first();
                    if($rateTheoryGradeSheet){
                        $savedRateAssignTheoryGradeSheet = RateAssign::getTeacherWithCourse(
                            $session_info->id,
                            $exam_type,
                            $rateTheoryGradeSheet->id
                        );

                        $preparatonTheroyGradeSheetData = RateAmount::where('exam_type_id', $exam_type)
                        ->where('rate_head_id', $rateTheoryGradeSheet->id)
                        ->where('session_id', $session_info->id)
                        ->first();
                        $theory_grade_sheet_per_subject_rate=$preparatonTheroyGradeSheetData?->default_rate;
                    }

                    //For ScrutinizersTheoryGradeSheet
                    $rateScrutinizersTheoryGradeSheet = RateHead::where('order_no', '=','10.a')->first();
                    if($rateScrutinizersTheoryGradeSheet){
                        $savedRateAssignScrutinizersTheoryGradeSheet = RateAssign::getTeacherWithCourse(
                            $session_info->id,
                            $exam_type,
                            $rateScrutinizersTheoryGradeSheet->id
                        );

                        $preparatonSessionalGradeSheetData = RateAmount::where('exam_type_id', $exam_type)
                        ->where('rate_head_id', $rateScrutinizersTheoryGradeSheet->id)
                        ->where('session_id', $session_info->id)
                        ->first();
                        $scrunizing_theory_grade_sheet_per_subject_rate=$preparatonSessionalGradeSheetData?->default_rate;
                    }

                     //For StencilCuttingCommittee
                    $rateStencilCuttingCommittee = RateHead::where('order_no', '=','12.a')->first();
                    if($rateStencilCuttingCommittee){
                        $savedRateAssignStencilCuttingCommittee = RateAssign::getTeachersFromCommittee(
                            $session_info->id,
                            $exam_type,
                            $rateStencilCuttingCommittee->id
                        );

                         $StencilCuttingData = RateAmount::where('exam_type_id', $exam_type)
                        ->where('rate_head_id', $rateStencilCuttingCommittee->id)
                        ->where('session_id', $session_info->id)
                        ->first();

                     $stencill_cutting_per_stencil_rate=$StencilCuttingData?->default_rate;
                    }

                    //For PrintingQuestion
                    $ratePrintingQuestion = RateHead::where('order_no', '=','12.b')->first();
                    if($ratePrintingQuestion){
                        $savedRateAssignPrintingQuestion = RateAssign::getTeachersFromCommittee(
                            $session_info->id,
                            $exam_type,
                            $ratePrintingQuestion->id
                        );

                        $PrintingQuestionData = RateAmount::where('exam_type_id', $exam_type)
                        ->where('rate_head_id', $ratePrintingQuestion->id)
                        ->where('session_id', $session_info->id)
                        ->first();
                        $print_question_paper_rate=$PrintingQuestionData?->default_rate;
                    }

                     //For ComparisonCommittee
                    $rateComparisonCommittee = RateHead::where('order_no', '=','11')->first();
                    if($rateComparisonCommittee){
                        $savedRateAssignComparisonCommittee = RateAssign::getTeachersFromCommittee(
                            $session_info->id,
                            $exam_type,
                            $rateComparisonCommittee->id
                        );

                        $ComparisonData = RateAmount::where('exam_type_id', $exam_type)
                        ->where('rate_head_id', $rateComparisonCommittee->id)
                        ->where('session_id', $session_info->id)
                        ->first();
                    $comparison_rate=$ComparisonData?->default_rate;
                    }

                     //For HonorariumChairman
                    $rateHonorariumChairman = RateHead::where('order_no', '=','15')->first();
                    if($rateHonorariumChairman){
                          $savedRateAssignHonorariumChairman = RateAssign::getTeachersFromCommittee(
                            $session_info->id,
                            $exam_type,
                            $rateHonorariumChairman->id
                        );
                          $HonorariumChairmanData  = RateAmount::where('exam_type_id', $exam_type)
                        ->where('rate_head_id', $rateHonorariumChairman->id)
                        ->where('session_id', $session_info->id)
                        ->first();

                       $honorium_chairman=$HonorariumChairmanData?->default_rate;
                    }
            }
       @endphp


        {{--order -1--}}
       @include('committee_input.patritals.review.list_moderation_committe')


        {{--order-2,3--}}

            @include('committee_input.patritals.review.list_paper_setter_examineer')



        {{--order-9--}}
        @include('committee_input.patritals.review.list_scrutinizers')


        {{--order-8.a--}}
        @include('committee_input.patritals.review.list_preparation_theory_grade_sheet')


        {{--order-10.a--}}
        @include('committee_input.patritals.review.list_scrutinizing_theory_grade_sheet')



        {{--order-12.a--}}
        @include('committee_input.patritals.review.list_stencil_cutting_question_paper')


        {{--order-12.b--}}

        @include('committee_input.patritals.review.list_printing_question_paper')


        {{--order-12.b--}}
        @include('committee_input.patritals.review.list_comparison_question_paper')

        {{--order-15--}}
        @include('committee_input.patritals.review.list_honorarium_chairman')























   <!-- end: page -->
</section>

@endsection
<!-- Add Script Data(You can write it any javascript file and than just import this js) -->
<!-- this will be fire for any 'delete' class element[const target = event.target.closest('.delete');] -->
@push('scripts')

@endpush


