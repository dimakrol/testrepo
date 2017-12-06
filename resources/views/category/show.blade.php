@extends('layouts.frontend.app')
@section('content')
    <div class="container">
        <h2>Category: {{ $category->name }}</h2>
    </div>
    <div class="background--grey">
        <div class="container">
            <div class="row">
                @foreach($category->videos as $video)
                    <div class="col-lg-4 col-sm-6 portfolio-item">
                        <div class="card h-100">
                            <a href="{{ route('video.show', $video->slug) }}"><img class="card-img-top" src="{{ $video->getThumbnail() }}" alt=""></a>
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
    </div>
@endsection