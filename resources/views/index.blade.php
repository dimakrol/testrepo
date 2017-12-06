@extends('layouts.frontend.app')
@section('content')

@include('flash::message')
<div id="wwd-carousel" class="carousel slide wwd-carousel" data-ride="carousel">
    <div class="carousel-inner">
        <div class="carousel-item carousel-item--first active">
            <div class="wwd-carousel__positioning">
                <h1 class="wwd-carousel__header"><span>Personalized Video Messages</span></h1>
                @if ($videos->count())
                    <p class="lead" align="center">
                        <a class="btn btn-success btn-lg" href="https://wordswontdo.com/video/work-of-art" role="button">Create video</a>
                    </p>
                @endif
            </div>
        </div>
        {{--<div class="carousel-item carousel-item--second">--}}
            {{--<div class="wwd-carousel__positioning">--}}
                {{--<h1 class="wwd-carousel__header"><span>Personalized Video Messages</span></h1>--}}
                {{--@if ($videos->count())--}}
                    {{--<p class="lead" align="center">--}}
                        {{--<a class="btn btn-success btn-lg" href="https://wordswontdo.com/video/work-of-art" role="button">Create video</a>--}}
                    {{--</p>--}}
                {{--@endif--}}
            {{--</div>--}}
        {{--</div>--}}
    </div>
    <a class="carousel-control-prev" href="#wwd-carousel" role="button" data-slide="prev">
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        <span class="sr-only">Previous</span>
    </a>
    <a class="carousel-control-next" href="#wwd-carousel" role="button" data-slide="next">
        <span class="carousel-control-next-icon" aria-hidden="true"></span>
        <span class="sr-only">Next</span>
    </a>
</div>

<div class="background--grey">
  <div class="container">
      <!-- Page Heading -->
          @foreach($playlists as $playlist)
              @if($playlist->videos->count())
                  <h1 class="my-4"><a href="{{$playlist->link ? route('category.show', $playlist->link): '#'}}">{{$playlist->name}}</a></h1>
                  <div class="row mx-2 mx-sm-0">
                      <div class="owl-carousel owl-theme">
                          @foreach($playlist->videos as $video)
                              <div class="portfolio-item">
                                  <div class="card h-100">
                                      <a href="{{ route('video.show', $video->slug) }}"><img class="card-img-top" src="{{ $video->getThumbnail() }}" alt=""></a>
                                      <div class="card-body">
                                          <div class="row">
                                              <div class="col-3">
                                                  <a href="{{ route('video.show', $video->slug) }}"><img src="{{ $video->user->thumbnail_path }}" class="rounded-circle img-fluid"></a>
                                              </div>
                                              <div class="col-9">
                                                  <h4>
                                                      <a href="{{ route('video.show', $video->slug) }}">{{ $video->name }}</a>
                                                  </h4>
                                                  <p class="card-text">Created by: <a href="{{ route('channel.index', $video->user->slug) }}">{{$video->user->fullName()}}</a></p>
                                              </div>
                                          </div>
                                      </div>
                                  </div>
                              </div>
                          @endforeach
                      </div>
                  </div>
              @endif
      @endforeach
  </div>
</div>

@endsection

@section('script')
    <script>
        $(function () {
            @if(null !== session('subscription'))
                fbq('track', 'Purchase', {value: '{{session('subscription')['value']}}', currency: '{{ session('subscription')['currency'] }}'});
                {{session()->forget('subscription')}}
            @endif
            @if(null !== session('completeRegistration'))
                fbq('track', 'CompleteRegistration');
                {{session()->forget('completeRegistration')}}
            @endif
        });
    </script>
@endsection