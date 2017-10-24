<div id="sidebar-wrapper">
    <ul class="sidebar-nav">
        <li class="sidebar-brand">
            <a href="{{ route('admin.index') }}">
                WWD Admin
            </a>
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
            <a href="{{ route('admin.field.create') }}">Create field</a>
        </li>
        {{--<li>--}}
            {{--<a href="#">About</a>--}}
        {{--</li>--}}
        {{--<li>--}}
            {{--<a href="#">Services</a>--}}
        {{--</li>--}}
        {{--<li>--}}
            {{--<a href="#">Contact</a>--}}
        {{--</li>--}}
    </ul>
</div>