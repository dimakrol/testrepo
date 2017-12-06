<!-- Navigation -->
<nav class="navbar navbar-expand fixed-top">
    <div class="container">
        <a class="navbar-brand" href="{{ url('/') }}">Words Won't Do</a>
        <div class="collapse navbar-collapse" id="navbarResponsive">
            <ul class="navbar-nav ml-auto">
                @guest
                    <li class="nav-item">
                        <a href="{{ route('register') }}" class="btn btn-success d-none d-sm-inline-block">Sign Up</a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('login') }}" class="btn btn-light menu-login-button mr-0">Login</a>
                    </li>
                @else
                    <div class="dropdown" role="menu">
                        <button class="btn btn-success dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            {{ Auth::user()->first_name }}
                        </button>
                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                            <a class="dropdown-item" href="{{route('subscription.index')}}">Subscription</a>
                            <a class="dropdown-item" href="{{route('my-videos')}}">My Videos</a>
                            <a class="dropdown-item" href="{{ route('logout') }}"
                               onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                Logout
                            </a>
                            @if(Auth::user()->is_admin)
                                <a class="dropdown-item" href="{{ route('admin.index') }}">
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
