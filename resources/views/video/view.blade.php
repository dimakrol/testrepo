@extends('layouts.frontend.app')
@section('styles')
    <meta property="fb:app_id" content="{{ config('services.facebook.client_id') }}"/>
    <meta property="og:url" content="{{ url()->current() }}"/>
    <meta property="og:type" content="article"/>
    <meta property="og:title" content="{{$gVideo->video->name}}"/>
    <meta property="og:image:secure_url" content="{{ $gVideo->video->getThumbnail() }}"/>
    <meta property="og:image:type" content="image/jpeg"/>
    <script>
        window.fbAsyncInit = function() {
            FB.init({
                appId            : '{{config('services.facebook.client_id')}}',
                autoLogAppEvents : true,
                xfbml            : true,
                version          : 'v2.12'
            });
        };

        (function(d, s, id){
            var js, fjs = d.getElementsByTagName(s)[0];
            if (d.getElementById(id)) {return;}
            js = d.createElement(s); js.id = id;
            js.src = "https://connect.facebook.net/en_US/sdk.js";
            fjs.parentNode.insertBefore(js, fjs);
        }(document, 'script', 'facebook-jssdk'));
    </script>
@endsection

@section('content')
    <div class="container bg-white flex-grow-1">
        <div class="video-view-alert alert alert-success" role="alert">
            Email has been send successfully!!!
        </div>
        <!-- This image for fb share don't delete it -->
        <img src="{{ $gVideo->video->getThumbnail() }}" width="1px" height="1px" alt="">
        <div class="row justify-content-center video pb-2 pt-0 flex-lg-column align-items-lg-center">
            <div class="col-md-10 col-lg-6">
                <div class="video-container" data-category="{{$gVideo->video->categoryName}}">
                    <video
                        data-category="{{ $gVideo->video->categoryName }}"
                        playsinline
                        poster="{{ $gVideo->video->getThumbnail() }}"
                        preload="auto"
                        class="center"
                        width="100%"
                        controls=""
                    >
                        <source src="{{ $gVideo->video_url }}" type="video/mp4">
                        Your browser does not support the video tag.
                    </video>
                </div>
            </div>
            <div class="col-sm-10 col-md-8 col-lg-5">
                <div class="form-group social-button">
                    <button style="cursor: pointer;" type="button" class="custom-button custom-button--facebook">
                        <i class="fa fa-facebook-square" aria-hidden="true"></i> Share on Facebook
                    </button>
                </div>
                <hr class="hr__with-text" data-text="or">
                <div class="text-center">
                    @unless($iPhone || $iPod)
                        <div class="form-group form-group--round-share">
                            <a href="{{ route('video.download', $gVideo->id) }}" class="custom-button custom-button--primary">
                                <i class="fa fa-download" aria-hidden="true"></i>
                            </a>
                        </div>
                    @endunless
                    <div class="form-group form-group--round-share">
                        <button type="button" class="custom-button custom-button--primary" data-toggle="modal" data-target="#share-via-email">
                            <i class="fa fa-envelope-square" aria-hidden="true"></i>
                        </button>
                    </div>
                    <div class="form-group form-group--round-share">
                        <button type="button" class="custom-button custom-button--primary" data-toggle="modal" data-target="#copy-link">
                            <i class="fa fa-link" aria-hidden="true"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>
        <h3 class="mb-3 your-own">Create your own:</h3>
        <div class="row justify-content-center pb-4">
            @foreach($videos as $video)
                <div class="col-12 col-md-6 col-lg-4 px-3 mb-3 mb-lg-0 portfolio-item">
                    <div class="card h-100">
                        <a href="{{ route('video.show', $video->slug) }}" data-category="{{ $video->categories()->count() ? $video->categories[0]->name : 'New'}}" class="{{ $video->categories()->count() ? $video->categories[0]->name : 'New'}}"><img class="card-img-top" src="{{ $video->getThumbnail() }}" alt=""></a>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    <div class="modal fade" id="share-via-email" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <form class="modal-content">
                <div class="modal-header mb-3">
                    <h5 class="modal-title" id="exampleModalLabel">Share via email</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="share-via-email">
                        <div class="alert alert-danger error-message-form" role="alert" style="display: none;"></div>
                        <label class="form-group" for="recipient-name">
                            <input type="text" class="form-control" id="recipient-name" placeholder="Name" required>
                        </label>
                        <label class="form-group" for="recipient-email">
                            <input type="email" class="form-control" id="recipient-email" placeholder="Email" required>
                        </label>
                        <label for="recipient-message" class="form-group">
                            <textarea class="form-control" id="recipient-message" cols="30" rows="4" placeholder="Message"></textarea>
                        </label>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button"
                            class="custom-button custom-button--primary share-via-email-but mb-3"
                            data-mail-route="{{route('share.email')}}"
                            data-share-link="{{route('view', $gVideo->hash)}}" style="cursor: pointer;">
                        Send
                    </button>
                    <button type="button" class="custom-button custom-button--gray">Preview</button>
                </div>
            </form>
        </div>
    </div>
    <div class="modal fade" id="copy-link" tabindex="-1" role="dialog" aria-labelledby="copy-link" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <form class="modal-content">
                <div class="modal-header mb-3">
                    <h5 class="modal-title" id="exampleModalLabel">Share via link</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body form-group mb-4">
                    <label id="share-label" class="w-100">
                        <input type="text" placeholder="Share Link" value="{{url()->current()}}" class="share-input" id="share-input" spellcheck="false">
                    </label>
                </div>
                <div class="modal-footer">
                    <button type="button" class="custom-button custom-button--primary" id="share-button">Copy link</button>
                    <button type="button" class="custom-button custom-button--hollow" data-dismiss="modal">Close</button>
                </div>

            </form>
        </div>
    </div>
@endsection

@section('script')
    <script>
        $(function () {

            var modalShare = $('#share-via-email');
            var alertEmail = $('.video-view-alert');
            var formModalAlert = $('.error-message-form');

            $(document).on('click', '.share-via-email-but', function () {
                var email = $('#recipient-email');
                var name = $('#recipient-name');
                var message = $('#recipient-message');
                var route = $(this).data('mail-route');
                var shareLink = $(this).data('share-link');

                $.ajax({
                    url: route,
                    type: 'POST',
                    data: {email: email.val(), name: name.val(), shareLink: shareLink},
                    dataType: 'json',
                    success: function(data) {
                        email.val('');
                        name.val('');
                        message.val('');
                        modalShare.modal('hide');
                        alertEmail.show().not('.alert-important').delay(4000).fadeOut(350);
                    },
                    error: function(data) {
                        var emailError = JSON.parse(data.responseText).errors.email[0];
                        formModalAlert.text(emailError).show().not('.alert-important').delay(4000).fadeOut(350);
                    }
                });
            });


            var popupSize = {
                width: 780,
                height: 550
            };

            $(document).on('click', '.social-button > .custom-button--facebook', function(e){
                FB.ui({
                    method: 'share',
                    display: 'popup',
                    href: '{{route('view', $gVideo->hash)}}',
                }, function(response){});
            });


        });

        function copyLink() {
            // select the input
            // hack used for iOS
            $('#share-input').focus();
            $('#share-input')[0].setSelectionRange(0, 999);
            // copy the path
            document.execCommand('copy');
            // show the message, hide it and remove from the DOM
            $('#share-label')
                .parent()
                .append(
                    '<div class="success-message">' +
                    '<small class="text-success">' +
                    'Link has been copied successfully' +
                    '</small>' +
                    '</div>'
                );
            $('.success-message').fadeOut(2000, function () {
                $(this).remove();
            });
        }

        $('#share-input').on('click', copyLink);
        $('#share-button').on('click', copyLink);
    </script>
@endsection