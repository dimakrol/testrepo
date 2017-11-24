@extends('layouts.admin.app')
@section('admin-content')
    <h2>Create user:</h2>
    {!! Form::open(['route' => 'admin.user.store']) !!}
    <div class="form-group col-md-6">
        <label for="inputName" class="col-form-label">Name:</label>
        {!! Form::text('name', null, ['class' => 'form-control', 'id' => 'inputName' , 'placeholder' => 'Name', 'required' => 'required']) !!}
    </div>
    <div class="form-group col-md-6">
        <label for="description" class="col-form-label">Description:</label>
        {!! Form::textarea('description', null, ['class' => 'form-control', 'id' => 'description' , 'placeholder' => 'Description', 'required' => 'required']) !!}
    </div>
    <div class="form-group col-md-6">
        {!! Form::select('role', ['creator' => 'Creator', 'admin' => 'Admin'], null, ['placeholder' => 'Select Role', 'class' => 'form-control']) !!}
    </div>
    <div class="form-group col-md-6">
        <button type="submit" class="btn btn-primary">Create</button>
    </div>
    {!! Form::close() !!}
@endsection