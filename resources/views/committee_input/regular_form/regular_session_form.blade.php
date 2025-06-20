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


            @include('committee_input.patritals.regular.list_moderation_committe')



            @include('committee_input.patritals.regular.list_paper_setter_examineer')




            @include('committee_input.patritals.regular.list_class_test_teacher')



            @include('committee_input.patritals.regular.list_sessional_course_teacher')


        {{--@include('committee_input.patritals.regular.list_moderation_committe_test')--}}


            @include('committee_input.patritals.regular.list_scrutinizers')






            @include('committee_input.patritals.regular.list_preparation_theory_grade_sheet')





            @include('committee_input.patritals.regular.list_preparation_sessional_grade_sheet')





            @include('committee_input.patritals.regular.list_scrutinizing_theory_grade_sheet')



        @include('committee_input.patritals.regular.list_scrutinizing_sessional_grade_sheet')

        @include('committee_input.patritals.regular.list_prepared_computerized_result')

        @include('committee_input.patritals.regular.list_verified_computerized_grade_sheet')

        @include('committee_input.patritals.regular.list_stencil_cutting_question_paper')
        @include('committee_input.patritals.regular.list_printing_question_paper')
        @include('committee_input.patritals.regular.list_comparison_question_paper')
        @include('committee_input.patritals.regular.list_advisor_student')
        @include('committee_input.patritals.regular.list_verified_final_graduation_result')
        @include('committee_input.patritals.regular.list_conducted_central_oral_examination')
        @include('committee_input.patritals.regular.list_involved_survey')
        @include('committee_input.patritals.regular.list_conducted_priliminary_viva')
        @include('committee_input.patritals.regular.list_examined_thesis_project')
        @include('committee_input.patritals.regular.list_conducted_oral_examination')
        @include('committee_input.patritals.regular.list_supervised_thesis_project')
        @include('committee_input.patritals.regular.list_honorarium_coordinator')
        @include('committee_input.patritals.regular.list_honorarium_chairman')



        <!-- end: page -->
    </section>

@endsection
<!-- Add Script Data(You can write it any javascript file and than just import this js) -->
<!-- this will be fire for any 'delete' class element[const target = event.target.closest('.delete');] -->
@push('scripts')

@endpush


