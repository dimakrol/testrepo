@extends('layouts.frontend.app')
@section('content')
    <div class="flex-grow-1">
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
                                <div class="row">
                                    <div class="col-3">
                                        <a href="{{ route('video.show', $video->slug) }}"><img src="{{ $video->user->thumbnail_path }}" class="rounded-circle img-fluid"></a>
                                    </div>
                                    <div class="col-9 d-flex justify-content-center flex-column">
                                        <h4 class="mb-0">
                                            <a class="video__title" href="{{ route('video.show', $video->slug) }}">{{ $video->name }}</a>
                                        </h4>
                                        <p class="card-text video__author">Created by: <a href="{{ route('channel.index', $video->user->slug) }}">{{$video->user->fullName()}}</a></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
@endsection