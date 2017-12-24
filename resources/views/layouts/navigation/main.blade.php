<!-- Navigation -->
<nav class="navbar navbar-expand fixed-top">
    <div class="container">
        <a class="navbar-brand" href="{{ url('/') }}">Words Won't Do</a>
        <div class="collapse navbar-collapse" id="navbarResponsive">
            <ul class="navbar-nav ml-auto">
                @guest
                    <li class="nav-item">
                        <a href="{{ route('login') }}" class="btn btn-light menu-login-button">Login</a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('register') }}" class="btn btn-success d-none d-sm-inline-block">Sign Up</a>
                    </li>
                @else
                    <div class="dropdown" role="menu">
                        <button class="btn btn-success dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            {{ Auth::user()->first_name }}
                        </button>
                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                            <a class="dropdown-item" href="{{route('account')}}">
                                <i class="fa fa-user" aria-hidden="true"></i>
                                My Account
                            </a>
                            @if (Auth::user()->subscribed(['yearly', 'yearlyuk']))
                                <a class="dropdown-item" href="{{route('my-videos')}}">
                                    <i class="fa fa-film" aria-hidden="true"></i>
                                    My Videos
                                </a>
                            @endif
                            <a class="dropdown-item" href="{{ route('logout') }}"
                               onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                <i class="fa fa-power-off" aria-hidden="true"></i>
                                Logout
                            </a>
                            @if(Auth::user()->is_admin)
                                <a class="dropdown-item" href="{{ route('admin.index') }}">
                                    <i class="fa fa-user-secret" aria-hidden="true"></i>
                                    Admin
                                </a>
                            @endif

                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                {{ csrf_field() }}
                            </form>
                        </div>
                    </div>
                @endguest
            </ul>
        </div>
    </div>
</nav>
