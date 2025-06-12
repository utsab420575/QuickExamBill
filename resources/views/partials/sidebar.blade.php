<aside id="sidebar-left" class="sidebar-left">
    <div class="sidebar-header">
        <div class="sidebar-title">
            Navigation
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
                            <span>eCommerce</span>
                        </a>
                        <ul class="nav nav-children">
                            <li>
                                <a class="nav-link" href="ecommerce-dashboard.html">
                                    Dashboard
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li>
                        <a class="nav-link" href="mailbox-folder.html">
                            <span class="float-end badge badge-primary">182</span>
                            <i class="bx bx-envelope" aria-hidden="true"></i>
                            <span>Mailbox</span>
                        </a>
                    </li>
                    <li class="nav-parent">
                        <a class="nav-link" href="#">
                            <i class="bx bx-file" aria-hidden="true"></i>
                            <span>Pages</span>
                        </a>
                        <ul class="nav nav-children">
                            <li>
                                <a class="nav-link" href="pages-signup.html">
                                    Sign Up
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li class="nav-parent">
                        <a class="nav-link" href="#">
                            <i class="bx bx-cube" aria-hidden="true"></i>
                            <span>UI Elements</span>
                        </a>
                        <ul class="nav nav-children">
                            <li>
                                <a class="nav-link" href="ui-elements-typography.html">
                                    Typography
                                </a>
                            </li>
                            <li class="nav-parent">
                                <a class="nav-link" href="#">
                                    Icons <span class="mega-sub-nav-toggle toggled float-end" data-toggle="collapse" data-target=".mega-sub-nav-sub-menu-1"></span>
                                </a>
                                <ul class="nav nav-children">
                                    <li>
                                        <a class="nav-link" href="ui-elements-icons-elusive.html">
                                            Elusive
                                        </a>
                                    </li>
                                    <li>
                                        <a class="nav-link" href="ui-elements-icons-font-awesome.html">
                                            Font Awesome
                                        </a>
                                    </li>
                                    <li>
                                        <a class="nav-link" href="ui-elements-icons-line-icons.html">
                                            Line Icons
                                        </a>
                                    </li>
                                    <li>
                                        <a class="nav-link" href="ui-elements-icons-meteocons.html">
                                            Meteocons
                                        </a>
                                    </li>
                                    <li>
                                        <a class="nav-link" href="ui-elements-icons-box-icons.html">
                                            Box Icons
                                        </a>
                                    </li>
                                </ul>
                            </li>
                        </ul>
                    </li>
                    <li class="nav-parent">
                        <a class="nav-link" href="#">
                            <i class="bx bx-map" aria-hidden="true"></i>
                            <span>Maps</span>
                        </a>
                        <ul class="nav nav-children">
                            <li>
                                <a class="nav-link" href="maps-google-maps.html">
                                    Basic
                                </a>
                            </li>
                            <li>
                                <a class="nav-link" href="maps-google-maps-builder.html">
                                    Map Builder
                                </a>
                            </li>
                            <li>
                                <a class="nav-link" href="maps-vector.html">
                                    Vector
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li>
                        <a class="nav-link" href="extra-ajax-made-easy.html">
                            <i class="bx bx-loader-circle" aria-hidden="true"></i>
                            <span>Ajax</span>
                        </a>
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
