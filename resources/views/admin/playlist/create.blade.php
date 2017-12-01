@extends('layouts.admin.app')
@section('admin-content')
    <div class="form-group col-md-6">
        <h2>Playlists:</h2>
    </div>
    @if($playlists->count() > 0)
        <ul class="list-group col-md-6 admin__playlist">
            @foreach($playlists as $playlist)
                <li id="item-{{$playlist->id}}" class="list-group-item">{{$playlist->name}}</li>
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

@section('script')
    <script>
        $('.admin__playlist').sortable({
            axis: 'y',
            update: function (event, ui) {
                var data = $(this).sortable('serialize');

                // POST to server using $.post or $.ajax
                $.ajax({
                    data: data,
                    type: 'POST',
                    url: '{{route('admin.playlist.change-order')}}'
                });
            }
        });
    </script>
@endsection