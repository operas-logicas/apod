<h2 class="display-4">Admin</h1>
<ul class="nav nav-tabs mt-3">
    <li class="nav-item">
        <a class="nav-link {{ Request::routeIs('posts.*') ? 'active' : '' }}" href="{{ route('posts.index') }}">Posts</a>
    </li>
    <li class="nav-item">
        <a class="nav-link {{ Request::routeIs('users.*') ? 'active' : '' }}" href="{{ route('users.index') }}">Users</a>
    </li>
</ul>
