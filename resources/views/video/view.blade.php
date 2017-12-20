@extends('layouts.frontend.app')
@section('styles')
    <meta property="og:url"           content="{{ url()->current() }}" />
    <meta property="og:type"          content="website" />
    <meta property="og:title"         content="Your Website Title" />
    <meta property="og:description"   content="Your description" />
    <meta property="og:image" content="{{ $gVideo->video_url }}"/>
    <meta property="og:image:secure_url" content="{{ $gVideo->video_url }}" />
@endsection

@section('content')
    <div class="container bg-white flex-grow-1">
        <div class="video-view-alert alert alert-success" role="alert">
            Email has been send successfully!!!
        </div>
        <div class="row justify-content-center video pb-5">
            <div class="col-md-10 col-lg-6 col-lg-offset-1">
                <div class="video-container" data-category="{{$gVideo->video->categoryName}}">
                    <video
                            data-category="{{ $gVideo->video->categoryName }}"
                            autoplay
                            loop
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
                <div class="video__description-container">
                    <a class="d-inline-block" href="{{ route('video.show', $gVideo->slug) }}">
                        <img src="{{ $gVideo->video->user->thumbnail_path }}" class="rounded-circle avatar">
                    </a>
                    <div>
                        <h2 class="video__title">{{ $gVideo->video->name }}</h2>
                        <p class="video__author">by: <a href="{{ route('channel.index', $gVideo->video->user->slug) }}">{{ $gVideo->video->user->first_name }}</a></p>
                    </div>
                </div>
            </div>
            <div class="col-sm-10 col-lg-5 pt-lg-3">
                <div class="form-group">
                    <label class="share-label" id="share-label">
                        <input type="text" placeholder="Share Link" value="{{url()->current()}}" class="share-input" id="share-input" spellcheck="false">
                        <i class="fa fa-link" aria-hidden="true"></i>
                    </label>
                </div>
                <div class="form-group social-button">
                    <a href="https://www.facebook.com/sharer/sharer.php?u={{urlencode(route('view', $gVideo->hash))}}" class="custom-button custom-button--facebook" target="_blank">
                        <i class="fa fa-facebook-square" aria-hidden="true"></i> Share on Facebook
                    </a>
                </div>
                <div class="form-group">
                    <button style="cursor: pointer;" type="button" class="custom-button custom-button--primary" data-toggle="modal" data-target="#share-via-email">
                        <i class="fa fa-envelope-square" aria-hidden="true"></i> Share via Email
                    </button>
                </div>
                @unless($iPhone || $iPod)
                    <div class="form-group">
                        <a href="{{ route('video.download', $gVideo->id) }}" class="custom-button custom-button--primary">
                            <i class="fa fa-download" aria-hidden="true"></i> Download
                        </a>
                    </div>
                @endunless
            </div>
        </div>
        <h3 class="mb-3 your-own">Create your own:</h3>
        <div class="row justify-content-center pb-4">
            @foreach($videos as $video)
                <div class="col-6 mb-2 px-2 portfolio-item">
                    <div class="card h-100">
                        <a href="{{ route('video.show', $video->slug) }}" data-category="{{$video->categoryName}}"><img class="card-img-top" src="{{ $video->getThumbnail() }}" alt=""></a>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    <div class="modal fade" id="share-via-email" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header mb-3">
                    <h5 class="modal-title" id="exampleModalLabel">New message</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form class="share-via-email">
                        <div class="alert alert-danger error-message-form" role="alert" style="display: none">
                        </div>
                        <div class="form-group">
                            <input type="email" class="form-control" id="recipient-email" placeholder="Email Address" required>
                        </div>
                        <div class="form-group mb-5">
                            <input type="text" class="form-control" id="recipient-name" placeholder="Recipient Name" required>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button"
                            class="custom-button custom-button--primary share-via-email-but"
                            data-mail-route="{{route('share.email')}}"
                            data-share-link="{{route('view', $gVideo->hash)}}" style="cursor: pointer;">
                        Send
                    </button>
                    <button type="button" class="custom-button custom-button--hollow" data-dismiss="modal">Close</button>
                </div>

            </div>
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


        })

        $('#share-input').on('click', function () {
            // select the input
            // hack used for iOS
            this.focus();
            this.setSelectionRange(0, 999);
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
        });
    </script>
@endsection