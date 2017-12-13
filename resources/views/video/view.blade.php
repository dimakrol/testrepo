@extends('layouts.frontend.app')
{{--@section('styles')--}}
    {{--<meta property="og:url"           content="http://www.your-domain.com/your-page.html" />--}}
    {{--<meta property="og:type"          content="website" />--}}
    {{--<meta property="og:title"         content="Your Website Title" />--}}
    {{--<meta property="og:description"   content="Your description" />--}}
    {{--<meta property="og:image" content="https://testwwdv2.s3-eu-west-1.amazonaws.com/thumbnails/1510154342JBCA9g7A4q.png"/>--}}
    {{--<meta property="og:image:secure_url" content="https://testwwdv2.s3-eu-west-1.amazonaws.com/thumbnails/1510154342JBCA9g7A4q.png" />--}}
{{--@endsection--}}

@section('content')
    <div class="container">
        <div class="row my-4">
            <div class="offset-lg-2 col-lg-8 col-sm-12 col-xs-12">
                <div class="video-view-alert alert alert-success" role="alert">
                    Email has been send successfully!!!
                </div>
                <h2 class="my-video-title" align="center"><span class="text-danger">{{$gVideo->video->name}}</span></h2>
                <div class="video-container"  data-category="{{$gVideo->video->categoryName}}">
                    <video data-category="{{ $gVideo->video->categoryName }}" autoplay poster="{{ $gVideo->video->getThumbnail() }}" preload="auto" class="center" width="100%" controls="">
                        <source src="{{ $gVideo->video_url }}" type="video/mp4">
                        Your browser does not support the video tag.
                    </video>
                </div>
                <div class="row my-video social-buttons">
                    <div class="col-lg-3 col-md-3 col-sm-4 col-xs-6">
                        <a href="{{ route('video.download', $gVideo->id) }}" class="btn btn-danger"><i class="fa fa-download" aria-hidden="true"></i> Download</a>
                    </div>
                    <div class="col-lg-3 col-md-3 col-sm-4 col-xs-6 social-button">
                        <a href="https://www.facebook.com/sharer/sharer.php?u={{urlencode(route('view', $gVideo->hash))}}" class="btn btn-warning" style="background-color: #4267B2"><i class="fa fa-facebook" aria-hidden="true"></i> Share</a>
                    </div>
                    <div class="col-lg-3 col-md-3 col-sm-4 col-xs-6">
                        <button style="cursor: pointer;" type="button" class="btn btn-success" data-toggle="modal" data-target="#share-via-email"><i class="fa fa-envelope-o" aria-hidden="true"></i> Share via Email</button>
                    </div>
                </div>
                <h3 class="your-own">Create your own:</h3>
                <div class="row">
                    @foreach($videos as $video)
                        <div class="col-lg-6 col-sm-6 portfolio-item">
                            <div class="card h-100">
                                <a href="{{ route('video.show', $video->slug) }}" data-category="{{$video->categoryName}}"><img class="card-img-top" src="{{ $video->getThumbnail() }}" alt=""></a>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="share-via-email" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
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
                        <div class="form-group">
                            <input type="text" class="form-control" id="recipient-name" placeholder="Recipient Name" required>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button"
                            class="btn btn-success share-via-email-but"
                            data-mail-route="{{route('share.email')}}"
                            data-share-link="{{route('view', $gVideo->hash)}}" style="cursor: pointer;">Send</button>
                </div>

            </div>
        </div>
    </div>
@endsection

@section('script')
    <script>
        $(function () {

            let modalShare = $('#share-via-email');
            let submitEmailBut = $('.share-via-email-but');
            let alertEmail = $('.video-view-alert');
            let formModalAlert = $('.error-message-form');

            submitEmailBut.on('click', function () {
                let email = $('#recipient-email');
                let name = $('#recipient-name');
                let route = $(this).data('mail-route');
                let shareLink = $(this).data('share-link');
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
                        let emailError = JSON.parse(data.responseText).errors.email[0];
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

    </script>
@endsection