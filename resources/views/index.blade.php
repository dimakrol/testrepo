@extends('layouts.frontend.app')
@section('content')
<!-- Page Content -->
<div class="container">

    <div class="jumbotron">
        <h1 class="display-4" align="center">The Home of Personalised Video</h1>
        @guest
            <p class="lead" align="center">Already have ah account? <a href="{{route('login')}}">Log in</a></p>
            <p class="lead" align="center">
                <a class="btn btn-success btn-lg" href="{{route('register')}}" role="button">Sign Up</a>
            </p>
        @endguest
    </div>

</div>
<div class="background--grey">
  <div class="container">

      <!-- Page Heading -->
      <h1 class="my-4" align="center">Featured Videos{{--<small>Secondary Text</small>--}}</h1>

      <div class="row">
          @foreach($videos as $video)
              <div class="col-lg-4 col-sm-6 portfolio-item">
                  <div class="card h-100">
                      <a href="{{ route('video.show', $video->id) }}"><img class="card-img-top" src="{{ asset('images/default_for_video.png') }}" alt=""></a>
                      <div class="card-body">
                          <h4 class="card-title">
                              <a href="{{ route('video.show', $video->slug) }}">{{ $video->name }}</a>
                          </h4>
                          <p class="card-text">Created by: <a href="{{ route('channel.index', $video->user->slug) }}">{{$video->user->slug}}</a></p>
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
