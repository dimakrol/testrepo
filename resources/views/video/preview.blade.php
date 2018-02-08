@extends('layouts.frontend.app')

@section('content')
    <div class="container bg-white flex-grow-1">
        <div class="row justify-content-center video pb-5">
            <div class="col-md-10 col-lg-6 col-lg-offset-1">
                <div class="video-container" data-category="{{$originalVideo->categoryName}}">
                    <video
                        data-category="{{ $originalVideo->categoryName }}"
                        playsinline
                        poster="{{ $originalVideo->getThumbnail() }}"
                        preload="auto"
                        class="center"
                        width="100%"
                        controls=""
                        controlsList="nodownload"
                    >
                        <source src="{{ $generatedUrl }}" type="video/mp4">
                        Your browser does not support the video tag.
                    </video>
                </div>
                @if (!Auth::check())
                    <div class="form-group">
                        <a class="custom-button custom-button--primary" href="{{ route('register') }}">JOIN WORDS WON'T DO</a>
                    </div>
                @elseif(!Auth::user()->subscribed(['yearly', 'yearlyuk']))
                    <div class="form-group">
                        <a class="custom-button custom-button--primary" href="{{ route('subscription.index') }}">JOIN WORDS WON'T DO</a>
                    </div>
                @else
                <div class="form-group">
                    <a class="custom-button custom-button--danger" href="{{ route('home') }}">WORDS WON'T DO</a>
                </div>
                @endif
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script>
        var video = $('video');
        video.on('contextmenu', function(e) {
            e.preventDefault();
        });
    </script>

@endsection