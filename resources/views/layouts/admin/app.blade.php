@extends('layouts.frontend.app')
    {{--part for video preview--}}
    {{--<video width="400"--}}
    {{--poster="https://thumb9.shutterstock.com/display_pic_with_logo/826804/222220798/stock-vector-hand-pushing-virtual-search-bar-on-turquoise-background-internet-concept-222220798.jpg"--}}
    {{--controls>--}}
    {{--<source width="320" height="240" id="video_here">--}}
    {{--Your browser does not support HTML5 video.--}}
    {{--</video>--}}

    {{--<input type="file" name="file[]" class="file_multi_video" accept="video/*">--}}
    <div id="wrapper" class="toggled">
        @include('layouts.admin.sidebar')
        @section('content')
    </div>



@endsection