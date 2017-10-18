@extends('layouts.frontend.app')
@section('content')
    {{--part for video preview--}}
    {{--<video width="400"--}}
           {{--poster="https://thumb9.shutterstock.com/display_pic_with_logo/826804/222220798/stock-vector-hand-pushing-virtual-search-bar-on-turquoise-background-internet-concept-222220798.jpg"--}}
           {{--controls>--}}
        {{--<source width="320" height="240" id="video_here">--}}
        {{--Your browser does not support HTML5 video.--}}
    {{--</video>--}}

    {{--<input type="file" name="file[]" class="file_multi_video" accept="video/*">--}}
    <div id="wrapper" class="toggled">

        <!-- Sidebar -->
        <div id="sidebar-wrapper">
            <ul class="sidebar-nav">
                <li class="sidebar-brand">
                    <a href="#">
                        Start Bootstrap
                    </a>
                </li>
                <li>
                    <a href="#">Dashboard</a>
                </li>
                <li>
                    <a href="#">Shortcuts</a>
                </li>
                <li>
                    <a href="#">Overview</a>
                </li>
                <li>
                    <a href="#">Events</a>
                </li>
                <li>
                    <a href="#">About</a>
                </li>
                <li>
                    <a href="#">Services</a>
                </li>
                <li>
                    <a href="#">Contact</a>
                </li>
            </ul>
        </div>
        <!-- /#sidebar-wrapper -->

        <!-- Page Content -->
        <div id="page-content-wrapper">
            <div class="container-fluid">
                <table class="table">
                    <thead class="thead-default">
                    <tr>
                        <th>#</th>
                        <th>First Name</th>
                        <th>Last Name</th>
                        <th>Username</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <th scope="row">1</th>
                        <td>Mark</td>
                        <td>Otto</td>
                        <td>@mdo</td>
                    </tr>
                    <tr>
                        <th scope="row">2</th>
                        <td>Jacob</td>
                        <td>Thornton</td>
                        <td>@fat</td>
                    </tr>
                    <tr>
                        <th scope="row">3</th>
                        <td>Larry</td>
                        <td>the Bird</td>
                        <td>@twitter</td>
                    </tr>
                    </tbody>
                </table>
                {{--<h1>Simple Sidebar</h1>--}}
                {{--<p>This template has a responsive menu toggling system. The menu will appear collapsed on smaller screens, and will appear non-collapsed on larger screens. When toggled using the button below, the menu will appear/disappear. On small screens, the page content will be pushed off canvas.</p>--}}
                {{--<p>Make sure to keep all page content within the <code>#page-content-wrapper</code>.</p>--}}
                {{--<a href="#menu-toggle" class="btn btn-secondary" id="menu-toggle">Toggle Menu</a>--}}
            </div>
        </div>
        <!-- /#page-content-wrapper -->

    </div>
@endsection
