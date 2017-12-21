<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
@yield('styles')
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link href="{{ mix('css/app.css') }}" rel="stylesheet">
    <title>{{ config('app.name', 'Laravel') }}</title>
</head>
<body>
<div id="app">
    @include('layouts.navigation.main')
    <div id="wrapper" class="toggled flex-grow-1">
        <div id="page-content-wrapper">
            @include('layouts.admin.sidebar')
            <div class="flex-grow-1 p-3">
                <div class="container frontend-flash-container">
                    @include('flash::message')
                </div>
                @include('flash::message')
                @foreach($errors->all() as $message)
                    {{$message}}
                @endforeach
                @yield('admin-content')
            </div>
        </div>
    </div>
    <div class="footer text-center">
        <p>Copyright &copy; Words Wont Do Ltd</p>
        <p>
            <a href="http://help.wordswontdo.com/important-documents/terms-and-conditions-terms-of-use">Terms </a>&amp;
            <a href="http://help.wordswontdo.com/important-documents/privacy-policy-policy"> Privacy</a> |
            <a href="http://help.wordswontdo.com/add-a-title/contact-us"> Get In Touch</a> |
            <a href="http://help.wordswontdo.com/creators/become-a-creator"> Become a Creator</a>
        </p>
        <ul class="list-unstyled list-inline">
            <li class="list-inline-item">
                <a href="https://www.facebook.com/wordswontdo/" target="_blank" class="footer__link">
                    <i class="fa fa-facebook"></i>
                </a>
            </li>
            <li class="list-inline-item">
                <a href="https://twitter.com/WordsWontDo" target="_blank" class="footer__link">
                    <i class="fa fa-twitter"></i>
                </a>
            </li>
            <li class="list-inline-item">
                <a href="https://www.pinterest.co.uk/wordswontdo/" target="_blank" class="footer__link">
                    <i class="fa fa-pinterest"></i>
                </a>
            </li>
        </ul>
    </div>
</div>
<button class="admin-menu" id="admin-menu">
    <i class="fa fa-bars" aria-hidden="true"></i>
</button>

<!-- Scripts -->
<script src="{{ mix('js/admin-app.js') }}"></script>
<script>
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
</script>
@yield('script')

<script>
    $('div.alert').not('.alert-important').delay(3000).fadeOut(350);

    // show/hide sidebar
    $('#admin-menu').on('click', function () {
        $('.sidebar-wrapper').toggleClass('sidebar-wrapper--open');
    })
</script>

<!-- Intercom -->
</body>
</html>