@extends('layouts.frontend.app')
@section('content')
  <div class="hero">
    <div class="container">
      <div class="hero__icon"><img src="{{ $user->thumbnail_path }}" class="rounded-circle"></div>
      <h1 class="my-4" align="center">{{ $user->fullName() }}</h1>
      <p class="lead">Our amazing talent create videos that you can personalise and send to friends.<br> We like to have fun and we release new content every week.</p>
    </div>
  </div>
  <div class="background--grey">
    <div class="container">
      <div class="row">
          @foreach($user->videos as $video)
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
