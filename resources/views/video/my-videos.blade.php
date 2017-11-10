@extends('layouts.frontend.app')
@section('content')
    <div class="container">
        @if($gVideos->count())
        <div class="my-videos-title">
            <h1 align="center"><span class="text-danger">Your Videos</span></h1>
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
                    <th scope="row" class="text-center"><a href="{{ route('my-video', $gVideo->slug) }}"><img width="100" src="{{ $gVideo->video->thumbnail_path}}" alt=""></a></th>
                    <td class="text-center align-middle" ><a href="{{ route('my-video', $gVideo->slug) }}">{{ $gVideo->video->name }}</a></td>
                    <td class="text-center align-middle">{{ $gVideo->created_at->format('l jS \\of F Y h:i:s A') }}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
        <div class="row">
            <div class="mx-auto">
                {{ $gVideos->links() }}
            </div>
        </div>
        @else
        <div class="my-videos-title">
            <h1 align="center"><span class="text-danger">No videos yet.</span></h1>
        </div>
        @endif
    </div>
@endsection