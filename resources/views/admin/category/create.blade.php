@extends('layouts.admin.app')
@section('admin-content')
    <h2>Categories</h2>
    <ul class="list-group col-md-6">
        <li class="list-group-item">Cras justo odio</li>
        <li class="list-group-item">Dapibus ac facilisis in</li>
        <li class="list-group-item">Morbi leo risus</li>
        <li class="list-group-item">Porta ac consectetur ac</li>
        <li class="list-group-item">Vestibulum at eros</li>
    </ul>

    {!! Form::open(['route' => 'admin.category.store']) !!}
    <div class="form-group col-md-6">
        <label for="inputName" class="col-form-label">Category new:</label>
        {!! Form::text('name', null, ['class' => 'form-control', 'id' => 'inputName' , 'placeholder' => 'Category name', 'required' => 'required']) !!}
    </div>
    <div class="form-group col-md-6">
        <button type="submit" class="btn btn-primary">Create</button>
    </div>
    {!! Form::close() !!}
@endsection