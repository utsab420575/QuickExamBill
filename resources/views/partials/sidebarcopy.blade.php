<aside id="sidebar-left" class="sidebar-left">
    <div class="sidebar-header">
        <div class="sidebar-title">
            Prepare Exam Bill
        </div>
        <div class="sidebar-toggle d-none d-md-block" data-toggle-class="sidebar-left-collapsed" data-target="html"
             data-fire-event="sidebar-left-toggle">
            <i class="fas fa-bars" aria-label="Toggle sidebar"></i>
        </div>
    </div>
    <div class="nano">
        <div class="nano-content">
            <nav id="menu" class="nav-main" role="navigation">
                <ul class="nav nav-main">
                    <li>
                        <a class="nav-link" href="{{route('dashboard')}}">
                            <i class="bx bx-home-alt" aria-hidden="true"></i>
                            <span>Dashboard</span>
                        </a>
                    </li>

                    @if(Auth::user()->can('import.menu'))
                        <li class="nav-parent">
                            <a class="nav-link" href="#">
                                {{--<i class="bx bx-cart-alt" aria-hidden="true"></i>--}}
                                <i class="fa-solid fa-file-import" aria-hidden="true"></i>
                                <span>Import/Export Manage</span>
                            </a>
                            <ul class="nav nav-children">
                                @if(Auth::user()->can('import.table.all'))
                                    <li>
                                        <a class="nav-link" href="{{route('import.table.all')}}">
                                            All Table Import
                                        </a>
                                    </li>
                                @endif
                            </ul>
                        </li>
                    @endif


                    @if(Auth::user()->can('committee_input.menu'))
                        <li class="nav-parent">
                            <a class="nav-link" href="#">
                                <i class="fa-solid fa-money-check-dollar" aria-hidden="true"></i>
                                <span>Committee Input Manage</span>
                            </a>
                            <ul class="nav nav-children">
                                @if(Auth::user()->can('committee.input.regular.session'))
                                    <li>
                                        <a class="nav-link" href="{{route('committee.input.regular.session')}}">
                                            All Regular Session
                                        </a>

                                    </li>
                                @endif

                                @if(Auth::user()->can('committee.input.review.session'))
                                    <li>
                                        <a class="nav-link" href="{{route('committee.input.review.session')}}">
                                            All Review Session
                                        </a>
                                    </li>
                                @endif
                            </ul>
                        </li>
                    @endif


                    @if(Auth::user()->can('committee_record.menu'))
                        <li class="nav-parent">
                            <a class="nav-link" href="#">
                                <i class="bx bx-file" aria-hidden="true"></i>
                                <span>Committee Record Manage</span>
                            </a>
                            <ul class="nav nav-children">
                                <li>
                                    <a class="nav-link" href="">
                                        All Regular Session
                                    </a>
                                </li>

                                <li>
                                    <a class="nav-link" href="">
                                        All Review Session
                                    </a>
                                </li>
                            </ul>
                        </li>
                    @endif


                    @if(Auth::user()->can('teacher.menu'))
                        <li class="nav-parent">
                            <a class="nav-link" href="#">
                                <i class="fa-solid fa-user-tie" aria-hidden="true"></i>
                                <span>Committee Teacher Manage</span>
                            </a>
                            <ul class="nav nav-children">

                                @if(Auth::user()->can('teacher.all'))
                                <li>
                                    <a class="nav-link" href="{{route('teacher.all')}}">
                                        All Teacher
                                    </a>
                                </li>
                                @endif

                                @if(Auth::user()->can('teacher.add'))
                                <li>
                                    <a class="nav-link" href="{{route('teacher.add')}}">
                                        Add Teacher
                                    </a>
                                </li>
                                    @endif
                            </ul>
                        </li>
                    @endif

                    @if(Auth::user()->can('employee.menu'))
                        <li class="nav-parent">
                            <a class="nav-link" href="#">
                                <i class="fa-solid fa-users" aria-hidden="true"></i>
                                <span>Committee Employee Manage</span>
                            </a>
                            <ul class="nav nav-children">
                                @if(Auth::user()->can('employee.all'))
                                    <li>
                                        <a class="nav-link" href="{{route('employee.all')}}">
                                            All Employee
                                        </a>
                                    </li>
                                @endif

                                @if(Auth::user()->can('employee.add'))
                                <li>
                                    <a class="nav-link" href="{{route('employee.add')}}">
                                        Add Employee
                                    </a>
                                </li>
                                    @endif
                            </ul>
                        </li>
                    @endif

                    @if(Auth::user()->can('report.menu'))
                        <li class="nav-parent">
                            <a class="nav-link" href="#">
                                <i class="fa-solid fa-file-pdf" aria-hidden="true"></i>
                                <span>Committee Report Manage</span>
                            </a>
                            <ul class="nav nav-children">
                                @if(Auth::user()->can('report.regular.session'))
                                <li>
                                    <a class="nav-link" href="{{route('report.regular.session')}}">
                                        All Regular Session
                                    </a>
                                </li>
                                @endif

                                @if(Auth::user()->can('report.review.session'))
                                <li>
                                    <a class="nav-link" href="{{route('report.review.session')}}">
                                        All Review Session
                                    </a>
                                </li>
                                    @endif
                            </ul>
                        </li>
                    @endif
                    @if(Auth::user()->can('role_permisssion.menu'))
                        {{--Permission Management--}}
                        <li class="nav-parent">
                            <a class="nav-link" href="#">
                                <i class="fa-solid fa-toolbox" aria-hidden="true"></i>
                                <span> Roles And Permission</span>
                            </a>
                            <ul class="nav nav-children">
                                @if(Auth::user()->can('permission.all'))
                                <li>
                                    <a class="nav-link" href="{{route('permission.all')}}">
                                        All Permission
                                    </a>
                                </li>
                                @endif

                                @if(Auth::user()->can('roles.all'))
                                <li>
                                    <a class="nav-link" href="{{route('roles.all')}}">
                                        All Roles
                                    </a>
                                </li>
                                    @endif

                                @if(Auth::user()->can('roles.permission.all'))
                                <li>
                                    <a class="nav-link" href="{{route('roles.permission.all')}}">
                                        All Roles in Permission
                                    </a>
                                </li>
                                        @endif

                                @if(Auth::user()->can('roles.permissions.add'))
                                    <li>
                                        <a class="nav-link" href="{{route('roles.permissions.add')}}">
                                            Roles in Permission
                                        </a>
                                    </li>
                                            @endif


                            </ul>
                        </li>
                    @endif
                    @if(Auth::user()->can('role_assign.menu.menu'))
                        {{--Role Assignment To Model(User)--}}
                        <li class="nav-parent">
                            <a class="nav-link" href="#">
                                <i class="fa-solid fa-lock-open" aria-hidden="true"></i>
                                <span> Setting Admin User </span>
                            </a>
                            <ul class="nav nav-children">
                                @if(Auth::user()->can('role.assignments.all'))
                                    <li>
                                        <a class="nav-link" href="{{route('role.assignments.all')}}">
                                            All User
                                        </a>
                                    </li>
                                @endif

                            </ul>
                        </li>
                    @endif
                </ul>
            </nav>
        </div>
        <script>
            // Maintain Scroll Position
            if (typeof localStorage !== 'undefined') {
                if (localStorage.getItem('sidebar-left-position') !== null) {
                    var initialPosition = localStorage.getItem('sidebar-left-position'),
                        sidebarLeft = document.querySelector('#sidebar-left .nano-content');
                    sidebarLeft.scrollTop = initialPosition;
                }
            }
        </script>
    </div>
</aside>
