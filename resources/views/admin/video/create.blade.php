@extends('layouts.admin.app')
@section('admin-content')
    <h2>Upload new video</h2>
        {!! Form::open(['route' => 'admin.video.store', 'files' => true]) !!}
            <div class="form-group">
                <label for="inputName" class="col-form-label">Name:</label>
                {!! Form::text('name', null, ['class' => 'form-control', 'id' => 'inputName' , 'placeholder' => 'Video Name', 'required' => 'required']) !!}
            </div>
            <div class="form-group">
                <label for="inputImpossibleVideoId" class="col-form-label">Impossible Video Id:</label>
                {!! Form::text('impossible_video_id', null, ['class' => 'form-control', 'id' => 'inputImpossibleVideoId' , 'placeholder' => 'Impossible Video Id', 'required' => 'required']) !!}
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
                <label for="inputImage">Select image thumbnail</label>
                {!! Form::file('image', ['class' => 'form-control-file', 'id' => 'inputImage' , 'accept' => 'image/*', 'required' => 'required']) !!}
            </div>
            <div class="form-group">
                {!! Form::label('user_id', 'Creator:') !!}
                {!! Form::select('user_id', $creators, null, ['class' => 'form-control']) !!}
            </div>
            <div class="form-group">
                {!! Form::label('categories[]', 'Categories:') !!}
                {!! Form::select('categories[]', $categories, null, ['class' => 'form-control select2-multi', 'multiple' => "multiple"]) !!}
            </div>
            <div class="form-group">
                {!! Form::label('tags[]', 'Tags:') !!}
                {!! Form::select('tags[]', $tags, null, ['class' => 'form-control select2-multi', 'multiple' => "multiple"]) !!}
            </div>
            <div class="form-group">
                {!! Form::label('playlists[]', 'Playlists:') !!}
                {!! Form::select('playlists[]', $playlists, null, ['class' => 'form-control select2-multi', 'multiple' => "multiple"]) !!}
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

@section('script')
    <script>
        $('.select2-multi').select2();
    </script>
@endsection