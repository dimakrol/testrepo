@extends('layouts.frontend.app')
@section('content')

@include('flash::message')
<div class="jumbotron hero hero--home">
    <h1 class="display-2" align="center"><span>Personalized Video Messages</span></h1>
    @if ($videos->count())
        <p class="lead" align="center">
            <a class="btn btn-success btn-lg" href="https://wordswontdo.com/video/work-of-art" role="button">Create video</a>
        </p>
    @endif
</div>

<div class="background--grey">
  <div class="container">
      <!-- Page Heading -->
          @foreach($playlists as $playlist)
              @if($playlist->videos->count())
                  <h1 class="my-4" style="text-decoration: underline; text-decoration-color: #5DC09C">{{$playlist->name}}</h1>
                  <div class="row">
                    @foreach($playlist->videos->chunk(3)[0] as $video)
                          <div class="col-lg-4 col-sm-6 portfolio-item">
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