<div id="sidebar-wrapper">
    <ul class="sidebar-nav">
        <li class="sidebar-brand">
            <a href="{{ route('admin.index') }}">
                WWD Admin
            </a>
        </li>
        <li>
            <a href="{{ route('admin.user.index') }}">Users</a>
        </li>
        <li>
            <a href="{{ route('admin.user.create') }}">Create User</a>
        </li>
        <li>
            <a href="{{ route('admin.subscription.index') }}">Subscriptions</a>
        </li>
        <li>
            <a href="{{ route('admin.video.index') }}">All Videos</a>
        </li>
        <li>
            <a href="{{ route('admin.video.create') }}">Create Video</a>
        </li>
        <li>
            <a href="{{ route('admin.plan.index') }}">Plan edit</a>
        </li>
        <li>
            <a href="{{ route('admin.category.create') }}">Create Category</a>
        </li>
        <li>
            <a href="{{ route('admin.tag.create') }}">Create Tag</a>
        </li>
        <li>
            <a href="{{ route('admin.playlist.create') }}">Playlists</a>
        </li>
        <li>
            <a href="{{ route('admin.field.create') }}">Create field</a>
        </li>
    </ul>
</div>