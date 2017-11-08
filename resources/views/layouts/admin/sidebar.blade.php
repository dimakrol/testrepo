<div id="sidebar-wrapper">
    <ul class="sidebar-nav">
        <li class="sidebar-brand">
            <a href="{{ route('admin.index') }}">
                WWD Admin
            </a>
        </li>
        <li>
            <a href="{{ route('admin.user.create') }}">Users</a>
        </li>
        <li>
            <a href="{{ route('admin.video.index') }}">All Videos</a>
        </li>
        <li>
            <a href="{{ route('admin.video.create') }}">Create Video</a>
        </li>
        <li>
            <a href="{{ route('admin.category.create') }}">Create Category</a>
        </li>
        <li>
            <a href="{{ route('admin.tag.create') }}">Create tag</a>
        </li>
        <li>
            <a href="{{ route('admin.field.create') }}">Create field</a>
        </li>
    </ul>
</div>