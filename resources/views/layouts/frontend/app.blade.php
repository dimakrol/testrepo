<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Styles -->
    @yield('styles')

    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <title>{{ config('app.name', 'Laravel') }}</title>
    @auth
    <script>
        window.WWD = {
            stripe: {
                stripeKey: "{{ config('services.stripe.key') }}"
            },
            user: JSON.parse('{!! json_encode(Auth::user()) !!}')
        }
    </script>
    @endauth
    @guest
    <script>
        window.WWD = {
            stripe: {
                stripeKey: "{{ config('services.stripe.key') }}"
            },
            user: null
        }
    </script>
    @endguest
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
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
    </script>
    @yield('script')

    <script>
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
