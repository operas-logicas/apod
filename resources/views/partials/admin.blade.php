<h2 class="display-4">Admin</h1>
<ul class="nav nav-tabs mt-3">
    <li class="nav-item">
        <a class="nav-link {{ Request::routeIs('admin.posts.*') ? 'active' : '' }}" href="{{ route('admin.posts.index') }}">Posts</a>
    </li>
    <li class="nav-item">
        <a class="nav-link {{ Request::routeIs('admin.users.*') ? 'active' : '' }}" href="{{ route('admin.users.index') }}">Users</a>
    </li>
</ul>
