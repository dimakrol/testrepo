@extends('layouts.admin.app')
@section('admin-content')
<table class="table">
    <thead class="thead-default">
    <tr>
        <th>#</th>
        <th>First Name</th>
        <th>Last Name</th>
        <th>Username</th>
    </tr>
    </thead>
    <tbody>
    <tr>
        <th scope="row">1</th>
        <td>Mark</td>
        <td>Otto</td>
        <td>@mdo</td>
    </tr>
    <tr>
        <th scope="row">2</th>
        <td>Jacob</td>
        <td>Thornton</td>
        <td>@fat</td>
    </tr>
    <tr>
        <th scope="row">3</th>
        <td>Larry</td>
        <td>the Bird</td>
        <td>@twitter</td>
    </tr>
    </tbody>
</table>
    @foreach($videos as $video)
        <video src="{{ asset($video->local_url) }}" width="400" controls>
        <source width="320" height="240" id="video_here">
        Your browser does not support HTML5 video.
        </video>
    @endforeach
@endsection