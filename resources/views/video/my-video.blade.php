@extends('layouts.frontend.app')
@section('styles')
    <meta property="og:url"           content="http://www.your-domain.com/your-page.html" />
    <meta property="og:type"          content="website" />
    <meta property="og:title"         content="Your Website Title" />
    <meta property="og:description"   content="Your description" />
    <meta property="og:image"         content="{{ $gVideo->video->getThumbnail() }}" />
@endsection

@section('content')
    <div class="container">
        <div class="row my-4">
            <div class="offset-lg-2 col-lg-8 col-sm-12 col-xs-12 video-container">
                <h2 class="my-video-title" align="center"><span class="text-danger">{{$gVideo->video->name}}</span></h2>
                <video poster="{{ $gVideo->video->getThumbnail() }}" preload="auto" class="center" width="100%" controls="">
                    <source src="{{ $gVideo->video_url }}" type="video/mp4">
                    Your browser does not support the video tag.
                </video>
                <div class="row">
                    <p><img src="{{ $gVideo->video->getThumbnail() }}" alt=""></p>
                    <a href="{{ route('video.download', $gVideo->id) }}" class="btn btn-danger">Download</a>
                    <div id="fb-root"></div>
                    <div class="fb-share-button" data-href="{{ route('my-video', $gVideo->slug) }}" data-layout="button_count">button</div>
                    {{--<a href="https://www.facebook.com/sharer/sharer.php?u=YourPageLink.com&display=popup"> share this </a>--}}
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script>(function(d, s, id) {
            var js, fjs = d.getElementsByTagName(s)[0];
            if (d.getElementById(id)) return;
            js = d.createElement(s); js.id = id;
            js.src = "//connect.facebook.net/en_GB/sdk.js#xfbml=1&version=v2.4&appId=241110544128";
            fjs.parentNode.insertBefore(js, fjs);
        }(document, 'script', 'facebook-jssdk'));</script>
@endsection