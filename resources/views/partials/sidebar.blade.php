<aside id="sidebar-left" class="sidebar-left">
    <div class="sidebar-header">
        <div class="sidebar-title">
            Prepare Exam Bill
        </div>
        <div class="sidebar-toggle d-none d-md-block" data-toggle-class="sidebar-left-collapsed" data-target="html" data-fire-event="sidebar-left-toggle">
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
                    <li class="nav-parent">
                        <a class="nav-link" href="#">
                            <i class="bx bx-cart-alt" aria-hidden="true"></i>
                            <span>Import/Export Manage</span>
                        </a>
                        <ul class="nav nav-children">
                            <li>
                                <a class="nav-link" href="{{route('import.table.all')}}">
                                    All Table Import
                                </a>
                            </li>
                        </ul>
                    </li>

                    <li class="nav-parent">
                        <a class="nav-link" href="#">
                            <i class="bx bx-file" aria-hidden="true"></i>
                            <span>Committee Input Manage</span>
                        </a>
                        <ul class="nav nav-children">
                            <li>
                                <a class="nav-link" href="{{route('committee.input.regular.session')}}">
                                    All Regular Session
                                </a>
                            </li>

                            <li>
                                <a class="nav-link" href="{{route('committee.input.review.session')}}">
                                    All Review Session
                                </a>
                            </li>
                        </ul>
                    </li>

                    <li class="nav-parent">
                        <a class="nav-link" href="#">
                            <i class="bx bx-file" aria-hidden="true"></i>
                            <span>Committee Record Manage</span>
                        </a>
                        <ul class="nav nav-children">
                            <li>
                                <a class="nav-link" href="pages-signup.html">
                                    All Regular Session
                                </a>
                            </li>

                            <li>
                                <a class="nav-link" href="pages-signup.html">
                                    All Review Session
                                </a>
                            </li>
                        </ul>
                    </li>

                    <li class="nav-parent">
                        <a class="nav-link" href="#">
                            <i class="bx bx-file" aria-hidden="true"></i>
                            <span>Committee Report Manage</span>
                        </a>
                        <ul class="nav nav-children">
                            <li>
                                <a class="nav-link" href="pages-signup.html">
                                    All Regular Session
                                </a>
                            </li>

                            <li>
                                <a class="nav-link" href="pages-signup.html">
                                    All Review Session
                                </a>
                            </li>
                        </ul>
                    </li>



                </ul>
            </nav>
            <hr class="separator" />
            <div class="sidebar-widget widget-tasks">
                <div class="widget-header">
                    <h6>Projects</h6>
                    <div class="widget-toggle">+</div>
                </div>
                <div class="widget-content">
                    <ul class="list-unstyled m-0">
                        <li><a href="#">Porto HTML5 Template</a></li>
                        <li><a href="#">Tucson Template</a></li>
                        <li><a href="#">Porto Admin</a></li>
                    </ul>
                </div>
            </div>
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
