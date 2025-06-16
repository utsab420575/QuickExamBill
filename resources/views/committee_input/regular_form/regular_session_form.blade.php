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
            <h2>Light Sidebar Layout</h2>
            <div class="right-wrapper text-end">
                <ol class="breadcrumbs">
                    <li>
                        <a href="index.html">
                            <i class="bx bx-home-alt"></i>
                        </a>
                    </li>
                    <li><span>Layouts</span></li>
                    <li><span>Light Sidebar</span></li>
                </ol>
                <a class="sidebar-right-toggle" data-open="sidebar-right"><i class="fas fa-chevron-left"></i></a>
            </div>
        </header>
        <!-- start: page -->

        @php
            $rate_head = \App\Models\RateHead::where('order_no', 1)->first();
            $session = \App\Models\Session::where('ugr_id', $sid)->where('exam_type_id', 1)->first();
            $rate_amount = $session
                ? \App\Models\RateAmount::where('session_id', $session->id)->where('saved', 1)->first()
                : null;
        @endphp

        @if(!$rate_amount)
            @include('committee_input.patritals.regular.list_moderation_committe')
        @else
            <div class="alert alert-info">
                Moderation Committee already saved for {{$session->session}} Year/{{$session->year}} Semester/{{$session->semester}}. If any update is needed, go to <strong>Committee Record Manage → Select Session</strong>.
            </div>
        @endif

      {{--  @include('committee_input.patritals.regular.list_moderation_committe_test')--}}
        @include('committee_input.patritals.regular.list_paper_setter_examineer')
        {{--@include('committee_input.patritals.regular.list_class_test_teacher')
        @include('committee_input.patritals.regular.list_sessional_course_teacher')
        @include('committee_input.patritals.regular.list_scrutinizers')
        @include('committee_input.patritals.regular.list_preparation_theory_grade_sheet')
        @include('committee_input.patritals.regular.list_preparation_sessional_grade_sheet')
        @include('committee_input.patritals.regular.list_scrutinizing_theory_grade_sheet')
        @include('committee_input.patritals.regular.list_scrutinizing_sessional_grade_sheet')
        @include('committee_input.patritals.regular.list_prepared_computerized_result')
        @include('committee_input.patritals.regular.list_verified_computerized_result')
        @include('committee_input.patritals.regular.list_supervision_under_chairman_exam_committee')
        @include('committee_input.patritals.regular.list_advisor_student')
        @include('committee_input.patritals.regular.list_verified_final_graduation_result')
        @include('committee_input.patritals.regular.list_teachers_conducted_central_oral_exam')
        @include('committee_input.patritals.regular.list_involved_survey')
        @include('committee_input.patritals.regular.list_conducted_priliminary_viva')
        @include('committee_input.patritals.regular.list_examined_thesis_project')
        @include('committee_input.patritals.regular.list_conducted_oral_examination')
        @include('committee_input.patritals.regular.list_supervised_thesis_project')
        @include('committee_input.patritals.regular.list_honorarium_coordinator')
        @include('committee_input.patritals.regular.list_honorarium_chairman')--}}


        <!-- end: page -->
    </section>

@endsection
<!-- Add Script Data(You can write it any javascript file and than just import this js) -->
<!-- this will be fire for any 'delete' class element[const target = event.target.closest('.delete');] -->
@push('scripts')

@endpush


