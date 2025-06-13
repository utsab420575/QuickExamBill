<header class="header">
    <div class="logo-container">
        <a href="../4.3.0" class="logo">
            <img src="{{asset('backend/assets/img/logo.png')}}" width="75" height="35" alt="Porto Admin" />
        </a>
        <div class="d-md-none toggle-sidebar-left" data-toggle-class="sidebar-left-opened" data-target="html" data-fire-event="sidebar-left-opened">
            <i class="fas fa-bars" aria-label="Toggle sidebar"></i>
        </div>
    </div>
    <!-- start: search & user box -->
    <div class="header-right">


        @php
            $id = Auth::user()->id;
            $userData = App\Models\User::find($id);
        @endphp
        {{--<span class="separator"></span>--}}
        <div id="userbox" class="userbox pt-2">
            <a href="#" data-bs-toggle="dropdown">
                <figure class="profile-picture">
                    <img src="{{ (!empty($userData->photo)) ? url($userData->photo) : url('upload/no_image.jpg') }}" alt="user-image" class="rounded-circle">
                    {{--<img src="{{asset('backend/assets/img/!logged-user.jpg')}}" alt="Joseph Doe" class="rounded-circle" data-lock-picture="{{asset('backend/assets/img/!logged-user.jpg')}}" />--}}
                </figure>
                <div class="profile-info" data-lock-name="Exam Bill" data-lock-email="johndoe@okler.com">
                    <span class="name">{{$userData->name}}</span>
                    {{--<span class="role">Administrator</span>--}}
                </div>
                <i class="fa custom-caret"></i>
            </a>
            <div class="dropdown-menu">
                <ul class="list-unstyled mb-2">

                    <li   class="pt-4">
                        <a role="menuitem" tabindex="-1" href="{{route('user.profile')}}"><i class="bx bx-user-circle"></i> My Profile</a>
                    </li>

                    <li>
                        <a role="menuitem" tabindex="-1" href="{{route('user.password.change')}}"><i class="bx bx-user-circle"></i>Change Password</a>
                    </li>
                    <li class="divider"></li>
                    {{--<li>
                        <a role="menuitem" tabindex="-1" href="#" data-lock-screen="true"><i class="bx bx-lock"></i> Lock Screen</a>
                    </li>--}}
                    <li>
                        <a role="menuitem" tabindex="-1" href="{{route('user.logout')}}"><i class="bx bx-power-off"></i> Logout</a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
    <!-- end: search & user box -->
</header>
