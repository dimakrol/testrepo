@extends('layouts.admin.app')
@section('admin-content')
    <div class="form-group col-md-6">
        <h2>Tags:</h2>
    </div>
    @if($tags->count() > 0)
        <ul class="list-group col-md-6">
            @foreach($tags as $tag)
                <li class="list-group-item">{{$tag->name}}</li>
            @endforeach
        </ul>
    @else
        <div class="form-group">
            <h4>No categories added.</h4>
        </div>
    @endif

    {!! Form::open(['route' => 'admin.tag.store']) !!}
    <div class="form-group col-md-6">
        <label for="inputName" class="col-form-label">Tag new:</label>
        {!! Form::text('name', null, ['class' => 'form-control', 'id' => 'inputName' , 'placeholder' => 'Tag name', 'required' => 'required']) !!}
    </div>
    <div class="form-group col-md-6">
        <button type="submit" class="btn btn-primary">Create</button>
    </div>
    {!! Form::close() !!}
@endsection