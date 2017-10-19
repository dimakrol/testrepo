@extends('layouts.admin.app')
@section('admin-content')
    {{-- todo add normal flash messages --}}
    @foreach($errors->all() as $message)
        {{$message}}
    @endforeach
    <div class="col-md-6 col-xs-12">
        <h2>Update video {{ $video->name }}</h2>
    </div>
    <div class="col-md-6 col-xs-12">
        <video src="{{ asset('storage/'.$video->local_url) }}" width="400" controls>
            <source width="320" height="240" id="video_here">
            Your browser does not support HTML5 video.
        </video>
    </div>
    {!! Form::open(['route' => ['admin.video.update', $video->id], 'method'  => 'put', 'files' => true]) !!}
    <div class="form-group col-md-6 col-xs-12">
        <label for="inputName" class="col-form-label">Name:</label>
        {!! Form::text('name', $video->name, ['class' => 'form-control', 'id' => 'inputName' , 'placeholder' => 'Video Name', 'required' => 'required']) !!}
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
        {!! Form::select('category_id', $categories, $video->category_id, ['placeholder' => 'Select category', 'class' => 'form-control', 'required' => 'required']) !!}
    </div>
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