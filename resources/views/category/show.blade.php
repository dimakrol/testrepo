@extends('layouts.frontend.app')
@section('content')
    <div class="bg-lightGreen">
        <div class="container clearfix category__title-container">
            <h2 class="category__title">{{ $category->name }}</h2>
            <hr class="category__title-underline">
        </div>
    </div>
    <div class="container bg-white pt-4 pt-sm-5">
        <div class="row">
            @foreach($category->videos as $video)
                <div class="col-lg-4 col-sm-6 portfolio-item mb-3 mb-sm-4">
                    <div class="card h-100">
                        <a href="{{ route('video.show', $video->slug) }}" data-category="{{ $category->name }}">
                            <img class="card-img-top" src="{{ $video->getThumbnail() }}" alt="">
                        </a>
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