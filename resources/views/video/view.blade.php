@extends('layouts.frontend.app')
@section('styles')
    <meta property="og:url"           content="http://www.your-domain.com/your-page.html" />
    <meta property="og:type"          content="website" />
    <meta property="og:title"         content="Your Website Title" />
    <meta property="og:description"   content="Your description" />
    <meta property="og:image" content="https://testwwdv2.s3-eu-west-1.amazonaws.com/thumbnails/1510154342JBCA9g7A4q.png"/>
    <meta property="og:image:secure_url" content="https://testwwdv2.s3-eu-west-1.amazonaws.com/thumbnails/1510154342JBCA9g7A4q.png" />
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
                <div class="row my-video social-buttons">
                    <div class="col-lg-3 col-md-3 col-sm-4 col-xs-6">
                        <a href="{{ route('video.download', $gVideo->id) }}" class="btn btn-danger"><i class="fa fa-download" aria-hidden="true"></i> Download</a>
                    </div>
                    <div class="col-lg-3 col-md-3 col-sm-4 col-xs-6 social-button">
                        <a href="https://www.facebook.com/sharer/sharer.php?u={{urlencode(route('my-video', $gVideo->slug))}}" class="btn btn-warning" style="background-color: #4267B2"><i class="fa fa-facebook" aria-hidden="true"></i> Share</a>
                    </div>
                    {{--<div id="fb-root"></div>--}}
                    {{--<div class="fb-share-button" data-href="{{ route('my-video', $gVideo->slug) }}" data-layout="button_count">button</div>--}}
                    {{--<a href="https://www.facebook.com/sharer/sharer.php?u=YourPageLink.com&display=popup"> share this </a>--}}
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script>

        var popupSize = {
            width: 780,
            height: 550
        };

        $(document).on('click', '.social-button > a', function(e){

            var
                verticalPos = Math.floor(($(window).width() - popupSize.width) / 2),
                horisontalPos = Math.floor(($(window).height() - popupSize.height) / 2);

            var popup = window.open($(this).prop('href'), 'social',
                'width='+popupSize.width+',height='+popupSize.height+
                ',left='+verticalPos+',top='+horisontalPos+
                ',location=0,menubar=0,toolbar=0,status=0,scrollbars=1,resizable=1');

            if (popup) {
                popup.focus();
                e.preventDefault();
            }

        });
    </script>
@endsection