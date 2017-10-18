@extends('layouts.admin.app')
@section('admin-content')
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
    {{--@foreach($videos as $video)--}}
        {{--<video src="{{ asset($video->local_url) }}" width="400" controls>--}}
        {{--<source width="320" height="240" id="video_here">--}}
        {{--Your browser does not support HTML5 video.--}}
        {{--</video>--}}
    {{--@endforeach--}}
@endsection