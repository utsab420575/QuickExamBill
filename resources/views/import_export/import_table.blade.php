@extends('layouts.app')
@section('content')
    <section role="main" class="content-body">
        <header class="page-header">
            <h2>Accordions</h2>

            <div class="right-wrapper text-end">
                <ol class="breadcrumbs">
                    <li>
                        <a href="index.html">
                            <i class="bx bx-home-alt"></i>
                        </a>
                    </li>

                    <li><span>UI Elements</span></li>

                    <li><span>Accordions</span></li>

                </ol>

                <a class="sidebar-right-toggle" data-open="sidebar-right"><i class="fas fa-chevron-left"></i></a>
            </div>
        </header>

        <!-- start: page -->

        <div class="row">
            <div class="col-6">
                <h4 class="font-weight-bold text-dark">Select Table & Press Import</h4>
            </div>
            <div class="col-6">
                <h4 class="font-weight-bold text-dark text-center">Import Data Showing Section</h4>
            </div>
            <div class="col-md-6 col-lg-6 col-xl-6">
                <div class="accordion accordion-primary" id="parent">
                    <div class="card card-default">
                        <div class="card-header">
                            <h4 class="card-title m-0">
                                <a class="accordion-toggle" data-bs-toggle="collapse" data-bs-parent="#parent" data-bs-target="#child1">
                                    User Import
                                </a>
                            </h4>
                        </div>
                        <div id="child1" class="collapse show" data-bs-parent="#parent">
                            <div class="card-body text-end">
                                <button type="submit" class="btn btn-warning">
                                    <i class="fas fa-download"></i> Import Users
                                </button>
                            </div>
                        </div>
                    </div>

                    <div class="card card-default">
                        <div class="card-header">
                            <h4 class="card-title m-0">
                                <a class="accordion-toggle" data-bs-toggle="collapse" data-bs-parent="#parent" data-bs-target="#child2">
                                    Teacher Import
                                </a>
                            </h4>
                        </div>
                        <div id="child2" class="collapse show" data-bs-parent="#parent">
                            <div class="card-body text-end">
                                <button type="submit" class="btn btn-warning">
                                    <i class="fas fa-download"></i> Import Teachers
                                </button>
                            </div>
                        </div>
                    </div>

                    <div class="card card-default">
                        <div class="card-header">
                            <h4 class="card-title m-0">
                                <a class="accordion-toggle" data-bs-toggle="collapse" data-bs-parent="#parent" data-bs-target="#child3">
                                    Designation Import
                                </a>
                            </h4>
                        </div>
                        <div id="child3" class="collapse" data-bs-parent="#parent">
                            <div class="card-body text-end">
                                <button type="submit" class="btn btn-warning">
                                    <i class="fas fa-download"></i> Import Designation
                                </button>
                            </div>
                        </div>
                    </div>

                    <div class="card card-default">
                        <div class="card-header">
                            <h4 class="card-title m-0">
                                <a class="accordion-toggle" data-bs-toggle="collapse" data-bs-parent="#parent" data-bs-target="#child4">
                                    Department Import
                                </a>
                            </h4>
                        </div>
                        <div id="child4" class="collapse" data-bs-parent="#parent">
                            <div class="card-body text-end">
                                <button type="submit" class="btn btn-warning">
                                    <i class="fas fa-download"></i> Import Departments
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
            <div class="col-md-6 col-lg-6 col-xl-6">



                <section class="card">
                    <div class="card-body">
                        <table class="table table-bordered table-striped mb-0" id="datatable-default">
                            <thead>
                            <tr>
                                <th>SL NO.</th>
                                <th>Data</th>

                            </tr>
                            </thead>
                            <tbody>
                            <tr>
                                <td>Trident</td>
                                <td>Internet
                                    Explorer 4.0
                                </td>

                            </tr>








                            </tbody>
                        </table>
                    </div>
                </section>

            </div>

        </div>


        <!-- end: page -->
    </section>
@endsection
