@extends('layouts.admin.app')
@section('admin-content')
    @foreach($errors->all() as $message)
        {{$message}}
    @endforeach
    <h2>Upload new video</h2>
        {!! Form::open(['route' => 'admin.video.store', 'files' => true]) !!}
            <div class="form-group">
                <label for="inputName" class="col-form-label">Name:</label>
                <input type="text" name="name" class="form-control" id="inputName" placeholder="Name">
            </div>
            <div class="form-group">
                <div class="form-check">
                    <label class="form-check-label">
                        <input class="form-check-input" type="checkbox"> Premium
                    </label>
                </div>
            </div>
            <div class="form-group">
                <label for="exampleFormControlFile1">Select video file</label>
                <input type="file" name="video" class="form-control-file" id="exampleFormControlFile1" accept="video/*">
            </div>
            {{--in future--}}
            {{--<div class="form-group" style="display: none">--}}
                {{--<video width="400"--}}
                       {{--poster="https://thumb9.shutterstock.com/display_pic_with_logo/826804/222220798/stock-vector-hand-pushing-virtual-search-bar-on-turquoise-background-internet-concept-222220798.jpg"--}}
                       {{--controls>--}}
                    {{--<source width="320" height="240" id="video_here">--}}
                    {{--Your browser does not support HTML5 video.--}}
                {{--</video>--}}
                {{--<input type="file" name="file[]" class="file_multi_video" accept="video/*">--}}
            {{--</div>--}}
            {{--end in future--}}
            <button type="submit" class="btn btn-primary">Upload</button>
        {!! Form::close() !!}
@endsection