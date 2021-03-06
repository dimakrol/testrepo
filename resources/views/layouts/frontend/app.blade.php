<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
@yield('styles')
    <!-- Global site tag (gtag.js) - Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=UA-77556458-1"></script>
    <script>
      window.dataLayer = window.dataLayer || [];
      function gtag(){dataLayer.push(arguments);}
      gtag('js', new Date());

      gtag('config', 'UA-77556458-1');
    </script>

    <script>
        !function(f,b,e,v,n,t,s)
        {if(f.fbq)return;n=f.fbq=function(){n.callMethod? n.callMethod.apply(n,arguments):n.queue.push(arguments)};
            if(!f._fbq)f._fbq=n;n.push=n;n.loaded=!0;n.version='2.0';
            n.queue=[];t=b.createElement(e);t.async=!0;
            t.src=v;s=b.getElementsByTagName(e)[0];
            s.parentNode.insertBefore(t,s)}(window,document,'script',
            'https://connect.facebook.net/en_US/fbevents.js');
        fbq('init', '112667282703000'
        @auth
            ,{
                em: '{{Auth::user()->email}}',
                fn: '{{Auth::user()->first_name}}'
            }
        @endauth
        );
        fbq('track', 'PageView');
    </script>
    <!-- Google Tag Manager -->
    <script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
                new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
            j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
            'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
        })(window,document,'script','dataLayer','GTM-PTP75K8');</script>
    <!-- End Google Tag Manager -->

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Linking with AMP version of the site -->
    <link rel="amphtml" href="{{ url('/') }}/amp">

    <link href="{{ mix('css/app.css') }}" rel="stylesheet">
    <title>{{ config('app.name', 'Laravel') }}</title>
    @auth
    <script>
        window.WWD = {
            stripe: {
                stripeKey: "{{ config('services.stripe.key') }}"
            },
            user: JSON.parse('{{ Auth::user()->id }}')
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
<noscript>
    <!-- Google Tag Manager (noscript) -->
    <noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-PTP75K8"
                      height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
    <!-- End Google Tag Manager (noscript) -->
    <div id="app">
        @include('layouts.navigation.main')
        <div class="container frontend-flash-container">
            @include('flash::message')
        </div>
        @yield('content')
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

    <!-- Scripts -->
    <script src="{{ mix('js/app.js') }}"></script>
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
    <script>(function(){var w=window;var ic=w.Intercom;if(typeof ic==="function"){ic('reattach_activator');ic('update',intercomSettings);}else{var d=document;var i=function(){i.c(arguments)};i.q=[];i.c=function(args){i.q.push(args)};w.Intercom=i;function l(){var s=d.createElement('script');s.type='text/javascript';s.async=true;s.src='https://widget.intercom.io/widget/e8yc37gy';var x=d.getElementsByTagName('script')[0];x.parentNode.insertBefore(s,x);}if(w.attachEvent){w.attachEvent('onload',l);}else{w.addEventListener('load',l,false);}}})()</script>
    @auth
        <script>window.intercomSettings = { app_id: "e8yc37gy", name: "{{Auth::user()->first_name}}", email: "{{Auth::user()->email ?: ''}}", created_at: "{{Auth::user()->created_at->timestamp}}", has_purchased: "{{Auth::user()->subscribed(['yearly', 'yearlyuk'])?'true':'false'}}"}</script>
    @endauth

    @guest
        <script>window.intercomSettings = { app_id: "e8yc37gy" }</script>
    @endguest

    <script type="application/ld+json">
        { "@context" : "http://schema.org",
          "@type" : "Organization",
          "name" : "Words Won't Do",
          "url" : "https://wordswontdo.com",
          "sameAs" : [ "https://www.facebook.com/wordswontdo/",
            "https://twitter.com/WordsWontDo",
            "https://www.youtube.com/channel/UCYqbWBCJ7XGoMvkW9GGiuWw/",
            "https://plus.google.com/112423643265326272373",
            "https://pinterest.com/wordswontdo"]
        }
    </script>
</body>
</html>
