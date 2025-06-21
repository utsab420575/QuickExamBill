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
            <h2>Regular Session All Form</h2>
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
           $session = \App\Models\Session::where('ugr_id', $sid)->where('exam_type_id', 1)->first();
        @endphp

        @if($session && !RateAmount::isRateAmountSaved($sid, 1, '1'))
            @include('committee_input.patritals.regular.list_moderation_committe')
        @else
            <div class="alert alert-info">
                List of  Examination Committee already saved for {{$session->session}} Year/{{$session->year}} Semester/{{$session->semester}}.
                If any update is needed, go to <strong>Committee Record Manage → Select Session</strong>.
            </div>
        @endif

        @if($session && !RateAmount::isRateAmountSaved($sid, 1, '2'))
            @include('committee_input.patritals.regular.list_paper_setter_examineer')
        @else
            <div class="alert alert-info">
                List of  Paper Setter Committee already saved for {{$session->session}} Year/{{$session->year}} Semester/{{$session->semester}}.
                If any update is needed, go to <strong>Committee Record Manage → Select Session</strong>.
            </div>
        @endif


        @if($session && !RateAmount::isRateAmountSaved($sid, 1, 4))
            @include('committee_input.patritals.regular.list_class_test_teacher')
        @else
            <div class="alert alert-info">
                List of  Internal Assessment Committee already saved for {{$session->session}} Year/{{$session->year}} Semester/{{$session->semester}}.
                If any update is needed, go to <strong>Committee Record Manage → Select Session</strong>.
            </div>
        @endif

        @if($session && !RateAmount::isRateAmountSaved($sid, 1, 5))
            @include('committee_input.patritals.regular.list_sessional_course_teacher')
        @else
            <div class="alert alert-info">
                List of  Sessional  Committee already saved for {{$session->session}} Year/{{$session->year}} Semester/{{$session->semester}}.
                If any update is needed, go to <strong>Committee Record Manage → Select Session</strong>.
            </div>
        @endif


        @if($session && !RateAmount::isRateAmountSaved($sid, 1, 9))
            @include('committee_input.patritals.regular.list_scrutinizers')
        @else
            <div class="alert alert-info">
                List of  Scrutinizers  Committee already saved for {{$session->session}} Year/{{$session->year}} Semester/{{$session->semester}}.
                If any update is needed, go to <strong>Committee Record Manage → Select Session</strong>.
            </div>
        @endif

        @if($session && !RateAmount::isRateAmountSaved($sid, 1, '8.a'))
            @include('committee_input.patritals.regular.list_preparation_theory_grade_sheet')
        @else
            <div class="alert alert-info">
                List of  Preparation of Grade Sheet already saved for {{$session->session}} Year/{{$session->year}} Semester/{{$session->semester}}.
                If any update is needed, go to <strong>Committee Record Manage → Select Session</strong>.
            </div>
        @endif

        @if($session && !RateAmount::isRateAmountSaved($sid, 1, '8.b'))
            @include('committee_input.patritals.regular.list_preparation_sessional_grade_sheet')
        @else
            <div class="alert alert-info">
                List of  Teachers for the Preparation of Grade Sheet(Sessional) Committee already saved for {{$session->session}} Year/{{$session->year}} Semester/{{$session->semester}}.
                If any update is needed, go to <strong>Committee Record Manage → Select Session</strong>.
            </div>
        @endif

        @if($session && !RateAmount::isRateAmountSaved($sid, 1, '10.a'))
            @include('committee_input.patritals.regular.list_scrutinizing_theory_grade_sheet')
        @else
            <div class="alert alert-info">
                List of  Scrutinizing of Grade Sheet(Theoretical) Committee already saved for {{$session->session}} Year/{{$session->year}} Semester/{{$session->semester}}.
                If any update is needed, go to <strong>Committee Record Manage → Select Session</strong>.
            </div>
        @endif


        @if($session && !RateAmount::isRateAmountSaved($sid, 1, '10.b'))
            @include('committee_input.patritals.regular.list_scrutinizing_sessional_grade_sheet')
        @else
            <div class="alert alert-info">
                List of  Scrutinizing of Grade Sheet(Sessional)  Committee already saved for {{$session->session}} Year/{{$session->year}} Semester/{{$session->semester}}.
                If any update is needed, go to <strong>Committee Record Manage → Select Session</strong>.
            </div>
        @endif

        @if($session && !RateAmount::isRateAmountSaved($sid, 1, '8.d'))
            @include('committee_input.patritals.regular.list_prepared_computerized_result')
        @else
            <div class="alert alert-info">
                List of  Prepared Computerized Result  already saved for {{$session->session}} Year/{{$session->year}} Semester/{{$session->semester}}.
                If any update is needed, go to <strong>Committee Record Manage → Select Session</strong>.
            </div>
        @endif

        @if($session && !RateAmount::isRateAmountSaved($sid, 1, '8.c'))
            @include('committee_input.patritals.regular.list_verified_computerized_grade_sheet')
        @else
            <div class="alert alert-info">
                List of  Verified Computerized Grade Sheets  Committee already saved for {{$session->session}} Year/{{$session->year}} Semester/{{$session->semester}}.
                If any update is needed, go to <strong>Committee Record Manage → Select Session</strong>.
            </div>
        @endif

        @if($session && !RateAmount::isRateAmountSaved($sid, 1, '12.a'))
            @include('committee_input.patritals.regular.list_stencil_cutting_question_paper')
        @else
            <div class="alert alert-info">
                List of  Stencill Cutting  Committee already saved for {{$session->session}} Year/{{$session->year}} Semester/{{$session->semester}}.
                If any update is needed, go to <strong>Committee Record Manage → Select Session</strong>.
            </div>
        @endif

        @if($session && !RateAmount::isRateAmountSaved($sid, 1, '12.b'))
            @include('committee_input.patritals.regular.list_printing_question_paper')
        @else
            <div class="alert alert-info">
                List of  Printing of Question  Committee already saved for {{$session->session}} Year/{{$session->year}} Semester/{{$session->semester}}.
                If any update is needed, go to <strong>Committee Record Manage → Select Session</strong>.
            </div>
        @endif

        @if($session && !RateAmount::isRateAmountSaved($sid, 1, 11))
            @include('committee_input.patritals.regular.list_comparison_question_paper')
        @else
            <div class="alert alert-info">
                List of  Comparison,Correction, Committee already saved for {{$session->session}} Year/{{$session->year}} Semester/{{$session->semester}}.
                If any update is needed, go to <strong>Committee Record Manage → Select Session</strong>.
            </div>
        @endif

        @if($session && !RateAmount::isRateAmountSaved($sid, 1, 13))
            @include('committee_input.patritals.regular.list_advisor_student')
        @else
            <div class="alert alert-info">
                List of  Advisory  already saved for {{$session->session}} Year/{{$session->year}} Semester/{{$session->semester}}.
                If any update is needed, go to <strong>Committee Record Manage → Select Session</strong>.
            </div>
        @endif

        @if($session && !RateAmount::isRateAmountSaved($sid, 1, 16))
            @include('committee_input.patritals.regular.list_verified_final_graduation_result')
        @else
            <div class="alert alert-info">
                List of  verified the final graduation results Committee already saved for {{$session->session}} Year/{{$session->year}} Semester/{{$session->semester}}.
                If any update is needed, go to <strong>Committee Record Manage → Select Session</strong>.
            </div>
        @endif

        @if($session && !RateAmount::isRateAmountSaved($sid, 1, '7.e'))
            @include('committee_input.patritals.regular.list_conducted_central_oral_examination')
        @else
            <div class="alert alert-info">
                List of  conducted central oral examination Committee already saved for {{$session->session}} Year/{{$session->year}} Semester/{{$session->semester}}.
                If any update is needed, go to <strong>Committee Record Manage → Select Session</strong>.
            </div>
        @endif

        @if($session && !RateAmount::isRateAmountSaved($sid, 1, '7.f'))
            @include('committee_input.patritals.regular.list_involved_survey')
        @else
            <div class="alert alert-info">
                List of  involved survey  Committee already saved for {{$session->session}} Year/{{$session->year}} Semester/{{$session->semester}}.
                If any update is needed, go to <strong>Committee Record Manage → Select Session</strong>.
            </div>
        @endif

        @if($session && !RateAmount::isRateAmountSaved($sid, 1, '6.c'))
            @include('committee_input.patritals.regular.list_conducted_priliminary_viva')
        @else
            <div class="alert alert-info">
                List of  conducted preliminary viva Committee already saved for {{$session->session}} Year/{{$session->year}} Semester/{{$session->semester}}.
                If any update is needed, go to <strong>Committee Record Manage → Select Session</strong>.
            </div>
        @endif

        @if($session && !RateAmount::isRateAmountSaved($sid, 1, '6.a'))
            @include('committee_input.patritals.regular.list_examined_thesis_project')
        @else
            <div class="alert alert-info">
                List of  examined thesis/projects Committee already saved for {{$session->session}} Year/{{$session->year}} Semester/{{$session->semester}}.
                If any update is needed, go to <strong>Committee Record Manage → Select Session</strong>.
            </div>
        @endif

        @if($session && !RateAmount::isRateAmountSaved($sid, 1, '6.d'))
            @include('committee_input.patritals.regular.list_conducted_oral_examination')
        @else
            <div class="alert alert-info">
                List of  conducted oral examination Committee already saved for {{$session->session}} Year/{{$session->year}} Semester/{{$session->semester}}.
                If any update is needed, go to <strong>Committee Record Manage → Select Session</strong>.
            </div>
        @endif

        @if($session && !RateAmount::isRateAmountSaved($sid, 1, '6.b'))
            @include('committee_input.patritals.regular.list_supervised_thesis_project')
        @else
            <div class="alert alert-info">
                List of  supervised the thesis/projects  Committee already saved for {{$session->session}} Year/{{$session->year}} Semester/{{$session->semester}}.
                If any update is needed, go to <strong>Committee Record Manage → Select Session</strong>.
            </div>
        @endif

        @if($session && !RateAmount::isRateAmountSaved($sid, 1, 14))
            @include('committee_input.patritals.regular.list_honorarium_coordinator')
        @else
            <div class="alert alert-info">
                List of  course co-ordinator already saved for {{$session->session}} Year/{{$session->year}} Semester/{{$session->semester}}.
                If any update is needed, go to <strong>Committee Record Manage → Select Session</strong>.
            </div>
        @endif

        @if($session && !RateAmount::isRateAmountSaved($sid, 1, 15))
            @include('committee_input.patritals.regular.list_honorarium_chairman')
        @else
            <div class="alert alert-info">
                List of  Chairman  already saved for {{$session->session}} Year/{{$session->year}} Semester/{{$session->semester}}.
                If any update is needed, go to <strong>Committee Record Manage → Select Session</strong>.
            </div>
        @endif


        {{--@include('committee_input.patritals.regular.list_moderation_committe_test')--}}

        <!-- end: page -->
    </section>

@endsection
<!-- Add Script Data(You can write it any javascript file and than just import this js) -->
<!-- this will be fire for any 'delete' class element[const target = event.target.closest('.delete');] -->
@push('scripts')

@endpush


