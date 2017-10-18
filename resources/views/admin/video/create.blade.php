@extends('layouts.admin.app')
@section('admin-content')
    {{-- todo add normal flash messages --}}
    @foreach($errors->all() as $message)
        {{$message}}
    @endforeach
    <h2>Upload new video</h2>
        {!! Form::open(['route' => 'admin.video.store', 'files' => true]) !!}
            <div class="form-group">
                <label for="inputName" class="col-form-label">Name:</label>
                {!! Form::text('name', null, ['class' => 'form-control', 'id' => 'inputName' , 'placeholder' => 'Video Name', 'required' => 'required']) !!}
            </div>
            <div class="form-group">
                <div class="form-check">
                    <label class="form-check-label">
                        {!! Form::checkbox('premium', null, null, ['class' => 'form-check-input']) !!} Premium
                    </label>
                </div>
            </div>
            <div class="form-group">
                <label for="inputVideo">Select video file</label>
                {!! Form::file('video', ['class' => 'form-control-file', 'id' => 'inputVideo' , 'accept' => 'video/*', 'required' => 'required']) !!}
            </div>
            <div class="form-group">
                {!! Form::select('category_id', $categories, null, ['placeholder' => 'Select category', 'class' => 'form-control', 'required' => 'required']) !!}
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