<!DOCTYPE html>
<html ⚡ lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <script async custom-element="amp-analytics" src="https://cdn.ampproject.org/v0/amp-analytics-0.1.js"></script>
    <script async src="https://cdn.ampproject.org/v0.js"></script>
    <script async custom-element="amp-carousel" src="https://cdn.ampproject.org/v0/amp-carousel-0.1.js"></script>
    <title>{{ config('app.name', 'Laravel') }}</title>
    <link rel="canonical" href="{{ url('/') }}">
    <link href="https://fonts.googleapis.com/css?family=Roboto+Condensed:400,700" rel="stylesheet">
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">
    <meta name="viewport" content="width=device-width,minimum-scale=1,initial-scale=1">
    <script type="application/ld+json">
        {
          "@context": "http://schema.org/",
          "@type": "WebSite",
          "name": "WordsWontDo",
          "url": "{{ url('/') }}/amp",
          "image": {
            "@type": "ImageObject",
            "url": "{{ url('/') }}/images/HomeHero_HNY.jpg",
            "height": 810,
            "width": 1440
          }
        }
    </script>
    <style amp-boilerplate>body{-webkit-animation:-amp-start 8s steps(1,end) 0s 1 normal both;-moz-animation:-amp-start 8s steps(1,end) 0s 1 normal both;-ms-animation:-amp-start 8s steps(1,end) 0s 1 normal both;animation:-amp-start 8s steps(1,end) 0s 1 normal both}@-webkit-keyframes -amp-start{from{visibility:hidden}to{visibility:visible}}@-moz-keyframes -amp-start{from{visibility:hidden}to{visibility:visible}}@-ms-keyframes -amp-start{from{visibility:hidden}to{visibility:visible}}@-o-keyframes -amp-start{from{visibility:hidden}to{visibility:visible}}@keyframes -amp-start{from{visibility:hidden}to{visibility:visible}}</style><noscript><style amp-boilerplate>body{-webkit-animation:none;-moz-animation:none;-ms-animation:none;animation:none}</style></noscript>
    <style amp-custom>
        /* any custom styles go here. */
        *,
        :after,
        :before {
            box-sizing: border-box;
            margin: 0;
        }
        html {
            background-color: #f7fafb;
        }
        body {
            font-family: 'Roboto Condensed', sans-serif;
            line-height: 1.5;
        }
        .row {
            display: flex;
            flex-wrap: wrap;
            margin-left: -15px;
            margin-right: -15px;
        }
        .col-3 {
            flex: 0 0 25%;
            max-width: 25%;
            padding-left: 15px;
            padding-right: 15px;
            width: 100%;
        }
        .col-9 {
            flex: 0 0 75%;
            max-width: 75%;
            padding-left: 15px;
            padding-right: 15px;
            width: 100%;
        }
        .d-flex {
            display: flex;
        }
        .justify-content-center {
            justify-content: center;
        }
        .flex-column {
            flex-direction: column;
        }
        .rounded-circle {
            border-radius: 50%;
        }
        .navbar {
            background: #fff;
            border-bottom: 5px solid #59b3a6;
            padding: .6875rem 1.125rem;
        }
        .navbar > .container {
            align-items: center;
            display: flex;
            flex-wrap: nowrap;
            justify-content: space-between;
            padding-left: 0;
            padding-right: 0;
        }
        .navbar-brand {
            color: #4b5157;
            font-size: 1.125rem;
            font-weight: bold;
            margin-right: 1rem;
            padding: .3125rem 0;
            text-decoration: none;
            text-transform: uppercase;
            transition: color .15s ease-in-out .15s;
            white-space: nowrap;
        }
        .navbar-brand:active,
        .navbar-brand:focus,
        .navbar-brand:hover {
            color: #82ceb2;
        }
        .menu-login-button {
            background-color: #f8f9fa;
            border: 0;
            border-radius: .25rem;
            color: #59b3a6;
            display: inline-block;
            font-size: 1.125rem;
            font-weight: bold;
            height: 2.25rem;
            line-height: 2.25rem;
            margin-right: .625rem;
            min-width: 8.75rem;
            padding: 0;
            text-align: center;
            text-decoration: none;
            transition: background-color .15s ease-in-out, border-color .15s ease-in-out, box-shadow .15s ease-in-out;
            vertical-align: middle;
            white-space: nowrap;
        }
        .menu-login-button:active,
        .menu-login-button:focus,
        .menu-login-button:hover {
            color: #111;
            background-color: #e2e6ea;
            border-color: #dae0e5;
        }
        .menu-signup-button {
            display: none;
        }
        .container--index {
            background-color: #fff;
            padding: .25rem .9375rem 0;
        }
        .carousel-container {
            margin-bottom: 1.5rem;
            position: relative;
        }
        .carousel__positioning {
            bottom: 0;
            left: 50%;
            position: absolute;
            text-align: center;
            transform: translateX(-50%);
        }
        .carousel__title {
            background-color: #fff;
            color: #59b3a6;
            display: inline-block;
            font-size: 1.75rem;
            font-weight: bold;
            line-height: 1.2;
            margin-bottom: .75rem;
            padding: .1875rem .3125rem;
            white-space: nowrap;
        }
        .carousel__cta {
            background: #59b3a6;
            border: 0;
            border-radius: .3rem;
            color: #fff;
            display: inline-block;
            font-size: 1.125rem;
            font-weight: bold;
            height: 2.25rem;
            line-height: 2.25rem;
            margin-bottom: 1.5rem;
            padding: 0;
            text-align: center;
            text-decoration: none;
            transition: background-color .15s ease-in-out,border-color .15s ease-in-out,box-shadow .15s ease-in-out;
            width: 8.75rem;
        }
        .carousel__cta:active,
        .carousel__cta:focus,
        .carousel__cta:hover {
            background: #7cc3b9;
            border: 0;
            box-shadow: none;
        }
        .playlist-title {
            align-items: center;
            display: flex;
            justify-content: space-between;
            line-height: 1.2;
            margin-bottom: 1.25rem;
            padding: 1rem .5rem .5rem;
        }
        .playlist-title__link {
            color: #282929;
            font-size: 1.25rem;
            font-weight: bold;
            text-decoration: none;
            transition: color .15s ease-in-out;

        }
        .playlist__container {
            margin-bottom: .625rem;
        }
        .playlist__container .amp-carousel-button-next,
        .playlist__container .amp-carousel-button-prev {
            background-color: #5dc09c;
            border-radius: 50%;
            cursor: pointer;
            height: 2.5rem;
            width: 2.5rem;
        }
        .playlist__container .amp-carousel-button-next {
            right: .4rem;
        }
        .playlist__container .amp-carousel-button-prev {
            left: .4rem;
        }
        .view-all-button {
            background-color: #f7fafb;
            border: 0;
            border-radius: .25rem;
            color: #5dc09c;
            cursor: pointer;
            font-size: .875rem;
            font-weight: bold;
            padding: .5rem;
            text-align: center;
            text-decoration: none;
            text-transform: capitalize;
            transition: color .15s ease-in-out,background-color .15s ease-in-out;
        }
        .view-all-button:active,
        .view-all-button:focus,
        .view-all-button:hover {
            color: #82ceb2;
        }
        .fa {
            font-size: 1.125rem;
        }
        .fa.fa-chevron-right {
            font-size: .75em;
        }
        .card {
            background-color: #fff;
            border: 1px solid rgba(0,0,0,.125);
            border-radius: .25rem;
        }
        .card-link {
            display: block;
        }
        .card-body {
            padding: 1.25rem;
        }
        .video__image {
            border-top-left-radius: .25rem;
            border-top-right-radius: .25rem;
        }
        .video__title {
            color: #282929;
            font-size: 1.125rem;
            font-weight: bold;
            line-height: 1.2;
            text-decoration: none;
        }
        .video__author {
            font-size: .875rem;
            margin-bottom: 0;
        }
        .video__author-link {
            color: #5dc09c;
            font-weight: bold;
            text-decoration: none;
            transition: color .15s ease-in-out;
        }
        .video__author-link:active,
        .video__author-link:focus,
        .video__author-link:hover {
            color: #82ceb2;
            text-decoration: underline;
        }
        .footer {
            background-color: #2f353b;
            color: #f5f6f8;
            font-size: .6875rem;
            padding: 2rem 0;
            text-align: center;
        }
        .footer p {
            color: #bac3cd;
            margin-bottom: 1rem;
        }
        .footer__link {
            color: #5dc09c;
            font-weight: bold;
            text-decoration: none;
            transition: color .15s ease-in-out;
        }
        .footer__link:active,
        .footer__link:focus,
        .footer__link:hover {
            color: #82ceb2;
            text-decoration: underline;
        }
        .socials {
            list-style: none;
            margin: 0;
            padding-left: 0;
        }
        .socials li {
            display: inline-block;
        }
        .socials li:not(:last-child) {
            margin-right: 5px;
        }
        .socials a {
            background-color: #2b3036;
            color: #4b5157;
            display: inline-block;
            font-size: 1.125rem;
            height: 2rem;
            margin: 0 2px;
            padding: 3px;
            transition: color .15s ease-in-out;
            width: 2rem;
        }
        .socials a:active,
        .socials a:focus,
        .socials a:hover {
            background-color: #252a2f;
            color: #82ceb2;
        }
        @media (min-width: 36em) {
            .container {
                margin-left: auto;
                margin-right: auto;
                max-width: 33.75rem;
            }
            .container--index {
                background-color: transparent;
            }
            .menu-login-button {
                margin-right: .625rem;
            }
            .menu-signup-button {
                background-color: #59b3a6;
                border: 0;
                border-radius: .25rem;
                color: #fff;
                display: inline-block;
                font-size: 1.125rem;
                font-weight: bold;
                vertical-align: middle;
                height: 2.25rem;
                line-height: 2.25rem;
                min-width: 8.75rem;
                padding: 0;
                text-align: center;
                text-decoration: none;
                transition: background-color .15s ease-in-out;
            }
            .menu-signup-button:active,
            .menu-signup-button:focus,
            .menu-signup-button:hover {
                background-color: #7cc3b9;
            }
            .carousel__title {
                font-size: 3rem;
                margin-bottom: 1.5rem;
            }
            .carousel__cta {
                height: 2.625rem;
                line-height: 2.625rem;
                margin-bottom: 3.5rem;
                width: 12.5rem;
            }
        }
        @media (min-width: 48em) {
            .navbar .container {
                max-width: 45rem;
            }
            .lg-col-2 {
                flex: 0 0 16.66667%;
                max-width: 16.66667%;
            }
            .wwd-carousel {
                max-height: 29.5rem;
            }
            .wwd-carousel .wwd-main-image > img {
                object-fit: cover;
            }
            .playlist-title__link {
                font-size: 1.875rem;
                position: relative;
            }
            .playlist-title__link:after {
                content: '';
                background-color: #5dc09c;
                bottom: -.5rem;
                display: inline-block;
                height: .5rem;
                left: 0;
                position: absolute;
                width: 5rem;
            }
            .view-all-button {
                font-size: 1.3125rem;
            }
        }
        @media (min-width: 62em) {
            .navbar .container {
                max-width: 60rem;
            }
            .navbar-brand {
                font-size: 1.875rem;
            }
        }
        @media (min-width: 75em) {
            .navbar .container {
                max-width: 71.25rem;
            }
        }
    </style>
</head>
<body>
<amp-analytics type="googleanalytics">
    <script type="application/json">
{
  "vars": {
    "account": "UA-77556458-1"
  },
  "triggers": {
    "trackPageview": {
      "on": "visible",
      "request": "pageview"
    }
  }
}
</script>
</amp-analytics>
<amp-pixel src="https://www.facebook.com/tr?id=112667282703000&ev=PageView&noscript=1" layout="nodisplay"></amp-pixel>
<nav class="navbar">
    <div class="container">
        <a class="navbar-brand" href="{{ url('/') }}">Words Won't Do</a>
        <div>
            <a class="menu-login-button" href="{{ route('login') }}">Login</a>
            <a class="menu-signup-button" href="{{ route('register') }}">Sign Up</a>
        </div>
    </div>
</nav>
<div id="app">
    <div class="carousel-container">
        <amp-carousel height="56vw"
                      class="wwd-carousel"
                      width="100vw"
                      layout="responsive"
                      type="slides">
            <amp-img src="{{ url("/images/Valentines-min.jpg") }}"
                     class="wwd-main-image"
                     width="1440"
                     height="810"
                     alt="Happy New Year!"
                     layout="responsive"></amp-img>
        </amp-carousel>
        <div class="carousel__positioning">
            <h1 class="carousel__title">Happy New Year!</h1>
            <br>
            <a href="video/happy-new-year" class="carousel__cta">Create video</a>
        </div>
    </div>
    <div class="container container--index">
        @foreach($playlists as $playlist)
            @if($playlist->videos->count())
                <h2 class="playlist-title">
                    <a class="playlist-title__link" href="{{$playlist->link ? route('category.show', $playlist->link): '#'}}">
                        {{$playlist->name}} Videos <i class="fa fa-chevron-right" aria-hidden="true"></i>
                    </a>
                    <a href="{{$playlist->link ? route('category.show', $playlist->link): '#'}}" class="view-all-button">
                        View All
                    </a>
                </h2>
                <div class="playlist__container">
                    <amp-carousel height="645" width="718" layout="responsive" type="slides" controls loop>
                        @foreach($playlist->videos as $video)
                            <div class="portfolio-item">
                                <div class="card">
                                    <a href="{{ route('video.show', $video->slug) }}" data-category="{{$playlist->categoryName}}" class="card-link {{ $video->categories()->count() ? $video->categories[0]->name : ''}}">
                                        <amp-img
                                            alt="{{ $video->categories()->count() ? $video->categories[0]->name : ''}} video"
                                            class="video__image"
                                            src="{{ $video->getThumbnail() }}"
                                            height="405"
                                            layout="responsive"
                                            width="718">
                                        </amp-img>
                                    </a>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-3 lg-col-2">
                                                <a href="{{ route('video.show', $video->slug) }}">
                                                    <amp-img
                                                            alt="{{ route('channel.index', $video->user->slug) }}"
                                                            class="rounded-circle"
                                                            src="{{ $video->user->thumbnail_path }}"
                                                            height="75"
                                                            layout="responsive"
                                                            width="75">
                                                    </amp-img>
                                                </a>
                                            </div>
                                            <div class="col-9 d-flex justify-content-center flex-column">
                                                <h4 class="mb-0">
                                                    <a class="video__title" href="{{ route('video.show', $video->slug) }}">{{ $video->name }}</a>
                                                </h4>
                                                <p class="video__author">by: <a class="video__author-link" href="{{ route('channel.index', $video->user->slug) }}">{{$video->user->fullName()}}</a></p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </amp-carousel>
                </div>
            @endif
        @endforeach
    </div>
</div>
<footer class="footer">
    <p>Copyright © Words Wont Do Ltd</p>
    <p>
        <a class="footer__link" href="//help.wordswontdo.com/important-documents/terms-and-conditions-terms-of-use">Terms</a> & <a class="footer__link" href="//help.wordswontdo.com/important-documents/privacy-policy-policy">Privacy</a> |
        <a class="footer__link" href="//help.wordswontdo.com/add-a-title/contact-us">Get In Touch</a> |
        <a class="footer__link" href="//help.wordswontdo.com/creators/become-a-creator">Become a Creator</a>
    </p>
    <ul class="socials">
        <li>
            <a href="https://www.facebook.com/wordswontdo/" target="_blank">
                <i class="fa fa-facebook"></i>
            </a>
        </li>
        <li>
            <a href="https://twitter.com/WordsWontDo" target="_blank">
                <i class="fa fa-twitter"></i>
            </a>
        </li>
        <li>
            <a href="https://www.pinterest.co.uk/wordswontdo/" target="_blank">
                <i class="fa fa-pinterest"></i>
            </a>
        </li>
    </ul>
</footer>
</body>
</html>
