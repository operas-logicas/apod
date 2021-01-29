<nav class="navbar navbar-expand-sm navbar-dark bg-dark">
    <a class="navbar-brand" href="{{ route('index') }}">APOD</a>
    <span class="navbar-text mr-auto">Astronomy Picture of the Day</span>
    <button class="navbar-toggler nowrap truncate" type="button" data-toggle="collapse" data-target="#toggleNav" aria-controls="toggleNav" aria-expanded="false" aria-label="Toggle Navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="container-fluid">
        <ul id="toggleNav" class="navbar-nav collapse navbar-collapse justify-content-end text-right">
            <li>
                <a class="nav-item nav-link {{ Request::routeIs('index') ? 'active' : '' }}" href="{{ route('index') }}">Home</a>
            </li>
            <li>
                <a class="nav-item nav-link {{ Request::routeIs('about') ? 'active' : '' }}" href="{{ route('about') }}">About</a>
            </li>
            @if(!Auth::check())
                <li>
                    <a class="nav-item nav-link {{ Request::is('login') ? 'active' : '' }}" href="{{ url('/login') }}">Login</a>
                </li>
                <li>
                    <a class="nav-item nav-link {{ Request::is('register') ? 'active' : '' }}" href="{{ url('/register') }}">Register</a>
                </li>
            @else
                <li>
                    <a class="nav-item nav-link {{ Request::routeIs('posts.index') ? 'active' : '' }}" href="{{ route('posts.index') }}">Posts</a>
                </li>
                <li>
                    <a class="nav-item nav-link {{ Request::routeIs('users.index') ? 'active' : '' }}" href="{{ route('users.index') }}">Users</a>
                </li>
                <li>
                    <a class="nav-item nav-link" href="{{ route('logout') }}"
                        onclick="
                            event.preventDefault();
                            document.getElementById('logout-form').submit();
                        ">Logout
                    </a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                        @csrf
                    </form>
                </li>
            @endif
        </ul>
    </div>
</nav>
