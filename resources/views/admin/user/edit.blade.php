@extends('layouts.admin.app')
@section('admin-content')
    <div class="col-md-6 col-xs-12">
        <h2>Edit {{ $user->first_name }} <img src="{{ $user->thumbnail_path }}" class="rounded-circle"></h2>
    </div>

    {!! Form::open(['route' => ['admin.user.update', $user->id], 'method'  => 'put', 'files' => true]) !!}
    <div class="form-group col-md-6">
        <label for="inputName" class="col-form-label">Creator name:</label>
        {!! Form::text('name', $user->first_name, ['class' => 'form-control', 'id' => 'inputName' , 'placeholder' => 'Creator name', 'required' => 'required']) !!}
    </div>
    <div class="form-group col-md-6">
        <label for="description" class="col-form-label">Description:</label>
        {!! Form::textarea('description', $user->description, ['class' => 'form-control', 'id' => 'description' , 'placeholder' => 'Creator Description']) !!}
    </div>
    <div class="form-group col-md-6">
        {!! Form::select('role', ['creator' => 'Creator', 'admin' => 'Admin'], $user->role, ['placeholder' => 'Select Role', 'class' => 'form-control']) !!}
    </div>
    <div class="form-group col-md-6">
        <label for="inputImage">Select image thumbnail to update</label>
        {!! Form::file('image', ['class' => 'form-control-file', 'id' => 'inputImage' , 'accept' => 'image/*']) !!}
    </div>
    <div class="form-group col-md-6">
        <button type="submit" class="btn btn-primary">Update</button>
    </div>
    {!! Form::close() !!}
@endsection