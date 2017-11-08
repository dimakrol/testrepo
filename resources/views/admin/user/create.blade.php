@extends('layouts.admin.app')
@section('admin-content')
    <table class="table">
        <thead class="thead-default">
        <tr>
            <th>Name</th>
            <th>Slug</th>
            <th>Created</th>
            <th></th>
        </tr>
        </thead>
        <tbody>
        @foreach($creators as $creator)
            <tr>
                <th scope="row">{{$creator->first_name}}</th>
                <td>{{$creator->slug}}</td>
                <td>{{$creator->created_at}}</td>
                <td><a href="">Login</a></td>
                {{--<td><a href="{{ route('admin.user.videos', $video->id) }}">{{$video->user->first_name}} {{$video->user->last_name}}</a></td>--}}
                {{--<td>No slug yet</td>--}}
                {{--<td>--}}
                    {{--<a href="{{ route('admin.video.edit', $video->id) }}"><i class="fa fa-pencil-square-o fa-lg" aria-hidden="true"></i></a>--}}
                {{--</td>--}}
            </tr>
        @endforeach
        </tbody>
    </table>

    {!! Form::open(['route' => 'admin.user.store']) !!}
    <div class="form-group col-md-6">
        <label for="inputName" class="col-form-label">Creator name:</label>
        {!! Form::text('name', null, ['class' => 'form-control', 'id' => 'inputName' , 'placeholder' => 'Creator name', 'required' => 'required']) !!}
    </div>
    <div class="form-group col-md-6">
        <label for="description" class="col-form-label">Description:</label>
        {!! Form::textarea('description', null, ['class' => 'form-control', 'id' => 'description' , 'placeholder' => 'Creator Description', 'required' => 'required']) !!}
    </div>
    <div class="form-group col-md-6">
        <button type="submit" class="btn btn-primary">Create</button>
    </div>
    {!! Form::close() !!}
@endsection