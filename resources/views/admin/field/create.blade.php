@extends('layouts.admin.app')
@section('admin-content')
    <div class="form-group col-md-6">
        <h2>Fields:</h2>
    </div>

    {!! Form::open(['route' => 'admin.field.store']) !!}

    <div class="form-group col-md-6">
        {!! Form::select('video_id', $videos, null, ['placeholder' => 'Select video', 'class' => 'form-control', 'required' => 'required']) !!}
    </div>

    <div class="form-group col-md-6">
        <label for="inputName" class="col-form-label">Field name:</label>
        {!! Form::text('name', null, ['class' => 'form-control', 'id' => 'inputName' , 'placeholder' => 'Field name', 'required' => 'required']) !!}
    </div>

    <div class="form-group col-md-6">
        <label for="inputVariableName" class="col-form-label">Variable name:</label>
        {!! Form::text('variable_name', null, ['class' => 'form-control', 'id' => 'inputVariableName' , 'placeholder' => 'Variable Name', 'required' => 'required']) !!}
    </div>

    <div class="form-group col-md-6">
        <label for="inputAspectRatio" class="col-form-label">Aspect Ratio:</label>
        {!! Form::text('aspect_ratio', null, ['class' => 'form-control', 'id' => 'inputAspectRatio' , 'placeholder' => 'Aspect Ratio', 'required' => 'required']) !!}
    </div>

    <div class="form-group col-md-6">
        {!! Form::select('type', ['image' => 'image', 'text_area' => 'text_area', 'text' => 'text'], null, ['placeholder' => 'Select Type', 'class' => 'form-control', 'required' => 'required']) !!}
    </div>

    <div class="form-group col-md-6">
        <button type="submit" class="btn btn-primary">Create</button>
    </div>
    {!! Form::close() !!}
@endsection