@extends('layouts.admin.app')
@section('admin-content')
    <div class="col-md-6 col-xs-12">
        <h2>Update video {{ $video->name }}</h2>
    </div>

        <div class="col-md-6 col-sm-12 col-xs-12">
            <video src="{{ $video->getVideoUrl() }}" width="400" controls>
                <source width="320" height="240" id="video_here">
                Your browser does not support HTML5 video.
            </video>
        </div>
        <div class="col-md-3 col-sm-9 col-xs-9">
            <p>Image thumbnail</p>
            <img src="{{ $video->getThumbnail() }}" class="img-fluid" alt="Responsive image">
        </div>


    {!! Form::open(['route' => ['admin.video.update', $video->id], 'method'  => 'put', 'files' => true]) !!}
    <div class="form-group col-md-6 col-xs-12">
        <label for="inputName" class="col-form-label">Name:</label>
        {!! Form::text('name', $video->name, ['class' => 'form-control', 'id' => 'inputName' , 'placeholder' => 'Video Name', 'required' => 'required']) !!}
    </div>
    <div class="form-group col-md-6 col-xs-12">
        <label for="inputImpossibleVideoId" class="col-form-label">Impossible Video Id:</label>
        {!! Form::text('impossible_video_id', $video->impossible_video_id, ['class' => 'form-control', 'id' => 'inputImpossibleVideoId' , 'placeholder' => 'Impossible Video Id', 'required' => 'required']) !!}
    </div>
    <div class="form-group col-md-6 col-xs-12">
        <div class="form-check">
            <label class="form-check-label">
                {!! Form::checkbox('premium', null, $video->premium, ['class' => 'form-check-input']) !!} Premium
            </label>
        </div>
    </div>
    <div class="form-group col-md-6 col-xs-12">
        <label for="inputVideo">Select video to change</label>
        {!! Form::file('video', ['class' => 'form-control-file', 'id' => 'inputVideo' , 'accept' => 'video/*']) !!}
    </div>
    <div class="form-group col-md-6 col-xs-12">
        <label for="inputImage">Select image to change thumbnail</label>
        {!! Form::file('image', ['class' => 'form-control-file', 'id' => 'inputImage' , 'accept' => 'image/*']) !!}
    </div>
    <div class="form-group col-md-6 col-xs-12">
        {!! Form::label('user_id', 'Creator:') !!}
        {!! Form::select('user_id', $creators, $video->user_id, ['class' => 'form-control']) !!}
    </div>
    <div class="form-group col-md-6 col-xs-12">
        {!! Form::label('categories[]', 'Categories:') !!}
        {!! Form::select('categories[]', $categories, null, ['class' => 'form-control select2-multi-categories', 'multiple' => "multiple"]) !!}
    </div>
    <div class="form-group col-md-6 col-xs-12">
        {!! Form::label('categories[]', 'Tags:') !!}
        {!! Form::select('tags[]', $tags, null, ['class' => 'form-control select2-multi', 'multiple' => "multiple"]) !!}
    </div>
    <table class="table col-md-12 col-xs-12">
        <thead class="thead-default">
        <tr>
            <th>Id</th>
            <th>Field Name:</th>
            <th>Variable Name:</th>
            <th>Type:</th>
            <th>Ratio:</th>
            <th>#</th>
        </tr>
        </thead>
        <tbody>
        @foreach($video->fields as $field)
            <tr>
                <th scope="row">{{$field->id}}</th>
                <th scope="row">{{$field->name}}</th>
                <th scope="row">{{$field->variable_name}}</th>
                <th scope="row">{{$field->type}}</th>
                <th scope="row">{{$field->aspect_ratio}}</th>
                <th scope="row">Actions</th>
            </tr>
        @endforeach
        </tbody>
    </table>

    <div class="row">
        <div style="margin-right: 5px">
            {{ Form::submit('Update', ['class' => 'btn btn-primary']) }}
        </div>
    {!! Form::close() !!}

    {!! Form::open([ 'method'  => 'delete', 'route' => [ 'admin.video.destroy', $video->id ] ]) !!}
            {{ Form::submit('Delete', ['class' => 'btn btn-danger']) }}
    {!! Form::close() !!}
    </div>
@endsection
@section('script')
    <script>
        $('.select2-multi').select2();
        $('.select2-multi-categories').select2().val({!! json_encode($video->categories()->pluck('id')) !!}).trigger('change');
        $('.select2-multi').select2().val({!! json_encode($video->tags()->pluck('id')) !!}).trigger('change');
    </script>
@endsection