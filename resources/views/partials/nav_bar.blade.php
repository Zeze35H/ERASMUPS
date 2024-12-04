@if($pageName === "Log In" || $pageName === "Sign Up" || $loggedIn === false)
    <div class="navbar-collapse collapse w-100 order-3 dual-collapse2" id="navbarSupportedContent">
        <ul class="navbar-nav ml-auto">
            <li class="nav-item">
                <a id="about_us_button" class="nav-link" href="{{url('aboutUs')}}">About Us</a>
            </li>
            <li class="nav-item">
                <a id="q_a_button" class="nav-link" href="{{url('questions')}}">Q&As</a>
            </li>
            <li class="nav-item">
                <a id="sign_up_button" class="nav-link " href="{{route('register')}}">Sign Up</a>
            </li>
            <li class="nav-item">
                <a id="log_in_button" class="nav-link " href="{{route('login')}}">Log In</a>
            </li>
        </ul>
    </div>
@else
    @if ($mod === true)
        <div class="navbar-collapse collapse w-100 order-3 dual-collapse2" id="navbarSupportedContent">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item ">
                    <a id="about_us_button" class="nav-link" href="{{url('aboutUs')}}">About Us </a>
                </li>
                <li class="nav-item">
                    <a id="q_a_button" class="nav-link" href="{{url('questions')}}">Q&As</a>
                </li>
                <li class="nav-item">
                    <a id="reports_button" class="nav-link" href="{{url('reports')}}">Reports</a>
                </li>
                <li class="nav-item">
                    <a id="mod_appeals_button" class="nav-link" href="{{url('modappeals')}}">Mod Appeals</a>
                </li>
                @if ($admin === true)
                    <li class="nav-item">
                        <a id="mods_dashboard_button" class="nav-link" href="{{url('modsdashboard')}}">Mods Dashboard</a>
                    </li>
                @endif
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    Profile
                    </a>
                    <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                    <a id="profile_button" class="dropdown-item" href="{{url('user/' . $idAuthUser)}}">My Profile
                    </a>
                    <a id="edit_profile_button" class="dropdown-item" href="{{url('user/' . $idAuthUser . '/edit')}}">Edit Profile</a>
                    </div>
                </li>
                <li class="nav-item">
                    <a id="log_out_button" class="nav-link" href="{{route('logout')}}">Log Out</a>
                </li>
            </ul>
        </div>
    @else
    <div class="navbar-collapse collapse w-100 order-3 dual-collapse2" id="navbarSupportedContent">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item ">
                    <a id="about_us_button" class="nav-link" href="{{url('aboutUs')}}">About Us </a>
                </li>
                <li class="nav-item">
                    <a id="q_a_button" class="nav-link" href="{{url('questions')}}">Q&As</a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    Profile
                    </a>
                    <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                    <a id="profile_button" class="dropdown-item" href="{{url('user/' . $idAuthUser)}}">My Profile
                    </a>
                    <a id="edit_profile_button" class="dropdown-item" href="{{url('user/' . $idAuthUser . '/edit')}}">Edit Profile</a>
                    </div>
                </li>
                <li class="nav-item">
                    <a id="log_out_button" class="nav-link" href="{{route('logout')}}">Log Out</a>
                </li>
            </ul>
        </div>
    @endif
@endif