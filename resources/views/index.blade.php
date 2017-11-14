@extends('layouts.frontend.app')
@section('content')
<!-- Page Content -->
{{--<div class="container">--}}
    @include('flash::message')
    <div class="jumbotron hero hero--home">
        <h1 class="display-2" align="center"><span>Personalized Video Messages</span></h1>
        <p class="lead">Our amazing talent create videos that you can personalise and send to friends.<br> We like to have fun and we release new content every week.</p>
        <p class="lead" align="center">
            <a class="btn btn-success btn-lg" href="{{ route('video.show', $videos[0]->slug) }}" role="button">Create video</a>
        </p>
        @guest
        <p class="lead" align="center">
            <a class="btn btn-success btn-lg" href="{{route('register')}}" role="button">Sign Up</a>
        </p>
        @endguest
    </div>

{{--</div>--}}
<div class="background--grey">
  <div class="container">

      <!-- Page Heading -->
      <h1 class="my-4" align="center">Featured Videos</h1>

      <div class="row">
          @foreach($videos as $video)
              <div class="col-lg-4 col-sm-6 portfolio-item">
                  <div class="card h-100">
                      <a href="{{ route('video.show', $video->slug) }}"><img class="card-img-top" src="{{ $video->getThumbnail() }}" alt=""></a>
                      <div class="card-body">
                          <div class="row">
                              <div class="col-3">
                                  <a href="{{ route('video.show', $video->slug) }}"><img src="{{ $video->user->thumbnail_path }}" class="rounded-circle img-fluid"></a>
                              </div>
                              <div class="col-9">
                                  <h4 class="card-title">
                                      <a href="{{ route('video.show', $video->slug) }}">{{ $video->name }}</a>
                                  </h4>
                                  <p class="card-text">Created by: <a href="{{ route('channel.index', $video->user->slug) }}">{{$video->user->slug}}</a></p>
                              </div>
                          </div>
                      </div>
                  </div>
              </div>
          @endforeach
      </div>
      <!-- /.row -->

      <!-- Pagination -->
      {{--<ul class="pagination justify-content-center">--}}
          {{--<li class="page-item">--}}
              {{--<a class="page-link" href="#" aria-label="Previous">--}}
                  {{--<span aria-hidden="true">&laquo;</span>--}}
                  {{--<span class="sr-only">Previous</span>--}}
              {{--</a>--}}
          {{--</li>--}}
          {{--<li class="page-item">--}}
              {{--<a class="page-link" href="#">1</a>--}}
          {{--</li>--}}
          {{--<li class="page-item">--}}
              {{--<a class="page-link" href="#">2</a>--}}
          {{--</li>--}}
          {{--<li class="page-item">--}}
              {{--<a class="page-link" href="#">3</a>--}}
          {{--</li>--}}
          {{--<li class="page-item">--}}
              {{--<a class="page-link" href="#" aria-label="Next">--}}
                  {{--<span aria-hidden="true">&raquo;</span>--}}
                  {{--<span class="sr-only">Next</span>--}}
              {{--</a>--}}
          {{--</li>--}}
      {{--</ul>--}}
  </div>
</div>

@endsection
