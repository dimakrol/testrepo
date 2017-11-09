@extends('layouts.frontend.app')
@section('content')
    <div class="container">
        <div class="my-videos-title">
            <h1 align="center">Your Videos</h1>
        </div>
        <table class="table">
            <thead>
            <tr>
                <th scope="col" class="text-center"><span class="text-uppercase">Thumbnail</span></th>
                <th scope="col" class="text-center"><span class="text-uppercase">video name</span></th>
                <th scope="col" class="text-center"><span class="text-uppercase">creation date</span></th>
            </tr>
            </thead>
            <tbody>
            @foreach($gVideos as $gVideo)
                <tr>
                    <th scope="row" class="text-center"><img width="100" src="{{ $gVideo->video->thumbnail_path}}" alt=""></th>
                    <td class="text-center"><a href="">{{ $gVideo->video->name }}</a></td>
                    <td class="text-center">{{ $gVideo->created_at->format('l jS \\of F Y h:i:s A') }}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
        <div class="row">
            <div class="mx-auto">
                {{ $gVideos->links() }}
            </div>
        </div>
    </div>
@endsection