@extends('layouts.frontend.app')
@section('content')
    <div class="container">

        <h1 class="my-4" align="center">{{ $user->fullName() }}</h1>

        <div class="row">
            @foreach($user->videos as $video)
                <div class="col-lg-4 col-sm-6 portfolio-item">
                    <div class="card h-100">
                        <a href="{{ route('video.show', $video->id) }}"><img class="card-img-top" src="{{ asset('images/default_for_video.png') }}" alt=""></a>
                        <div class="card-body">
                            <h4 class="card-title">
                                <a href="{{ route('video.show', $video->slug) }}">{{ $video->name }}</a>
                            </h4>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endsection