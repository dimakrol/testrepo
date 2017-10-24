<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <title>{{ config('app.name', 'Laravel') }}</title>
    @auth
    <script>
        window.WWD = {
            stripe: {
                stripeKey: "{{ config('services.stripe.key') }}"
            },
            user: JSON.parse('{!! json_encode(Auth::user()->with('subscriptions')->first()) !!}')
        }
    </script>
    @endauth
</head>
<body>
    <div id="app">
        @include('layouts.navigation.main')
        @yield('content')
    </div>
    <!-- Scripts -->
    <script src="https://checkout.stripe.com/checkout.js"></script>
    <script src="{{ asset('js/app.js') }}"></script>

    <script>
        $('.update-preview').on('click', function () {
            let fileInputs = $('input[type=file]');
            let videoId = $('video').data('id');

            let data = new FormData();
            $.each(fileInputs, function (index, fileInput) {
                $.each(fileInput.files, function (key, value) {
                    console.log('key: ' + key);
                    console.log('value: ' + value);
                    data.append(fileInput.name, value);
                })
//                console.log(fileInput.files[0].value);
//                data.append(fileInput.name, fileInput.files[0].value);
            });
            data.append('_token', $('input[name=_token]').val());
            data.append('id', videoId);
            console.log(data);
            $.ajax({
                url: '/video/generate',
                type: 'POST',
                data: data,
                cache: false,
                dataType: 'json',
                processData: false, // Don't process the files
                contentType: false, // Set content type to false as jQuery will tell the server its a query string request
                success: function(data) {
                    $('.video-container').html(`
                    <video data-id="${data.videoId}" poster="http://localhost:8000/images/loading_anim.gif" preload="auto" class="center" width="100%" controls="">
                        <source src="${data.videoUrl}" type="video/mp4">
                        Your browser does not support the video tag.
                    </video>`);
                },
                error: function(jqXHR, textStatus) {
                    console.log(textStatus);
                }
            });
        });
//        var video = document.getElementById('video');
//        var source = document.createElement('source');
//
//        source.setAttribute('src', 'http://www.tools4movies.com/trailers/1012/Kill%20Bill%20Vol.3.mp4');
//
//        video.appendChild(source);
//        video.play();
//
//        setTimeout(function() {
//            video.pause();
//
//            source.setAttribute('src', 'http://www.tools4movies.com/trailers/1012/Despicable%20Me%202.mp4');
//
//            video.load();
//            video.play();
//        }, 3000);
////        part for video preview
//        $(document).on("change", ".file_multi_video", function(evt) {
//            var $source = $('#video_here');
//            $source[0].src = URL.createObjectURL(this.files[0]);
//            $source.parent()[0].load();
//        });
//      toggle navbar
//    $("#menu-toggle").click(function(e) {
//        e.preventDefault();
//        $("#wrapper").toggleClass("toggled");
//    });
//todo move to separate file.
        $('div.alert').not('.alert-important').delay(3000).fadeOut(350);
    </script>
</body>
</html>
