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
        <div class="container frontend-flash-container">
            @include('flash::message')
        </div>
        @yield('content')
        <div class="footer text-center">
          <p>Copyright &copy; Words Wont Do Ltd</p>
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
        $('div.alert').not('.alert-important').delay(3000).fadeOut(350);
    </script>

    <!-- Intercom -->
    <script>window.intercomSettings = { app_id: "e8yc37gy"};</script>
    <script>(function(){var w=window;var ic=w.Intercom;if(typeof ic==="function"){ic('reattach_activator');ic('update',intercomSettings);}else{var d=document;var i=function(){i.c(arguments)};i.q=[];i.c=function(args){i.q.push(args)};w.Intercom=i;function l(){var s=d.createElement('script');s.type='text/javascript';s.async=true;s.src='https://widget.intercom.io/widget/e8yc37gy';var x=d.getElementsByTagName('script')[0];x.parentNode.insertBefore(s,x);}if(w.attachEvent){w.attachEvent('onload',l);}else{w.addEventListener('load',l,false);}}})()</script>

</body>
</html>
