@extends('layouts.admin.app')
@section('admin-content')
@if($videos->count() > 0)
<table class="table">
    <thead class="thead-default">
    <tr>
        <th>Id</th>
        <th>Name</th>
        <th>Slug</th>
        <th></th>
    </tr>
    </thead>
    <tbody>
        @foreach($videos as $video)
            <tr>
                <th scope="row">{{$video->id}}</th>
                <td>{{$video->name}}</td>
                <td>No slug yet</td>
                <td><a href="{{ route('admin.video.edit', $video->id) }}"><i class="fa fa-pencil-square-o fa-lg" aria-hidden="true"></i></a></td>
            </tr>
        @endforeach
    </tbody>
</table>
@else
<h3>No videos yet</h3>
@endif
{{ $videos->links() }}
@endsection