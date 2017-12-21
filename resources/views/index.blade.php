@extends('layouts.frontend.app')
@section('content')

@include('flash::message')
<div id="wwd-carousel" class="carousel slide wwd-carousel" data-ride="carousel">
    <div class="carousel-inner">
        {{--<div class="carousel-item carousel-item--first active">--}}
            {{--<div class="wwd-carousel__positioning">--}}
                {{--<h1 class="wwd-carousel__header"><span>New Christmas E-Cards!</span></h1>--}}
                {{--<p class="lead" align="center">--}}
                    {{--<a class="btn btn-success btn-lg" href="https://wordswontdo.com/video/merry-christmas" role="button">Create video</a>--}}
                {{--</p>--}}
            {{--</div>--}}
        {{--</div>--}}
        <div class="carousel-item carousel-item--first active">
            <div class="wwd-carousel__positioning">
                <h1 class="wwd-carousel__header"><span>New Christmas E-Cards!</span></h1>
                <p class="lead" align="center">
                    <a class="btn btn-success btn-lg" href="https://wordswontdo.com/video/queens-christmas-speech" role="button">Create video</a>
                </p>
            </div>
        </div>
        {{--<div class="carousel-item carousel-item--second">--}}
            {{--<div class="wwd-carousel__positioning">--}}
                {{--<h1 class="wwd-carousel__header"><span>New Christmas E-Cards!</span></h1>--}}
                {{--<p class="lead" align="center">--}}
                    {{--<a class="btn btn-success btn-lg" href="https://wordswontdo.com/video/santa-s-naughty-list" role="button">Create video</a>--}}
                {{--</p>--}}
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

<div class="background--grey pt-4 pb-sm-2 pb-md-5">
  <div class="container container--index">
      <!-- Page Heading -->
          @foreach($playlists as $playlist)
              @if($playlist->videos->count())
                  <h1 class="playlist-title">
                      <a class="playlist-title__link" href="{{$playlist->link ? route('category.show', $playlist->link): '#'}}">
                          {{$playlist->name}} Videos <i class="fa fa-chevron-right" aria-hidden="true"></i>
                      </a>
                      <a href="{{$playlist->link ? route('category.show', $playlist->link): '#'}}" class="custom-button custom-button--used view-all-button">
                          View All
                      </a>
                  </h1>
                  <div class="row mx-2 mx-sm-0">
                      <div id="playlist-owl-carousel-{{$playlist->id}}" class="owl-carousel owl-theme">
                          @foreach($playlist->videos as $video)
                              <div class="portfolio-item">
                                  <div class="card h-100">
                                      <a href="{{ route('video.show', $video->slug) }}" data-category="{{$playlist->categoryName}}">
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
                                                  <p class="card-text video__author">by: <a href="{{ route('channel.index', $video->user->slug) }}">{{$video->user->fullName()}}</a></p>
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
                //facebook track functionality(complete subscription)
                fbq('track', 'Purchase', {value: '{{session('subscription')['value']}}', currency: '{{ session('subscription')['currency'] }}'});
                {{session()->forget('subscription')}}
            @endif
            @if(null !== session('completeRegistration'))
                fbq('track', 'CompleteRegistration');
                {{session()->forget('completeRegistration')}}
            @endif


            // setting up carousel for playlists
            // parse all carousels from the page
            var playlists = $('[id^="playlist-owl-carousel-"]');

            // iterate each playlist
            for (var key = 0; key < playlists.length; key++) {
                // for each playlist
                var playlist = playlists[key];

                // set up the settings
                $(playlist).owlCarousel({
                    dots: false,
                    loop: true,
                    margin: 20,
                    nav: true,
                    navContainer: playlist,
                    navText: [
                        '<i class="fa fa-chevron-left" aria-hidden="true"></i>',
                        '<i class="fa fa-chevron-right" aria-hidden="true"></i>'
                    ],
                    responsive: {
                        0: {
                            items: 1
                        },
                        768: {
                            items: 2
                        },
                        992: {
                            items: 3,
                        }
                    }
                });
            }
        });
    </script>
@endsection