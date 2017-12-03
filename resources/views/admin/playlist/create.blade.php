@extends('layouts.admin.app')
@section('admin-content')
    <div class="form-group col-md-6">
        <h2>Playlists:</h2>
    </div>
    @if($playlists->count() > 0)
        <ul class="list-group col-md-6">
            @foreach($playlists as $playlist)
                <li class="list-group-item">{{$playlist->name}}</li>
            @endforeach
        </ul>
    @else
        <div class="form-group">
            <h4>No tags added.</h4>
        </div>
    @endif

    {!! Form::open(['route' => 'admin.playlist.store']) !!}
    <div class="form-group col-md-6">
        <label for="inputName" class="col-form-label">Playlist:</label>
        {!! Form::text('name', null, ['class' => 'form-control', 'id' => 'inputName' , 'placeholder' => 'Playlist name', 'required' => 'required']) !!}
    </div>
    <div class="form-group col-md-6">
        <button type="submit" class="btn btn-primary">Create</button>
    </div>
    {!! Form::close() !!}
@endsection