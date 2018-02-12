<!DOCTYPE html>
<html ⚡ lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <script async custom-element="amp-analytics" src="https://cdn.ampproject.org/v0/amp-analytics-0.1.js"></script>
    <script async src="https://cdn.ampproject.org/v0.js"></script>
    <script async custom-element="amp-video" src="https://cdn.ampproject.org/v0/amp-video-0.1.js"></script>
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
        .col-12 {
            flex: 0 0 100%;
            max-width: 100%;
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
        .container--video {
            background-color: #fff;
            padding: 1rem 1rem 2.5rem;
        }
        .video {

        }
        .video__container {
            margin-bottom: 1rem;
        }
        .video__description-container {
            align-items: center;
            display: flex;
            margin-bottom: 1.5625rem;
        }
        .video__avatar {
            display: inline-block;
            height: 2.8125rem;
            margin-right: .625rem;
            width: 2.8125rem;
        }
        .video__title {
            color: #282929;
            font-size: 1.125rem;
            font-weight: bold;
            margin-bottom: 0;
        }
        .video__author {
            font-size: .875rem;
            margin-bottom: 0;
        }
        .video__author > a {
            color: #5dc09c;
            font-weight: bold;
            transition: color .15s ease-in-out;
            text-decoration: none;
        }
        .video__author > a:active,
        .video__author > a:focus,
        .video__author > a:hover {
            color: #82ceb2;
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
            .col-sm-10 {
                flex: 0 0 83.33333%;
                max-width: 83.33333%;
            }
        }
        @media (min-width: 48em) {
            .container {
                max-width: 45rem;
            }
            .col-md-10 {
                flex: 0 0 83.33333%;
                max-width: 83.33333%;
            }
        }
        @media (min-width: 62em) {
            .container {
                max-width: 60rem;
            }
            .navbar-brand {
                font-size: 1.875rem;
            }
            .col-lg-5 {
                flex: 0 0 41.66667%;
                max-width: 41.66667%;
            }
            .col-lg-6 {
                flex: 0 0 50%;
                max-width: 50%;
            }
        }
        @media (min-width: 75em) {
            .container {
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
    <div class="container container--video">
        <div class="row justify-content-center video">
            <div class="col-12 col-md-10 col-lg-6">
                <amp-video
                        controls
                        controlsList="nodownload"
                        class="video__container"
                        {{--data-id="{{ $video->id }}"--}}
                        data-id="1"
                        width="960"
                        height="540"
                        layout="responsive"
                        {{--poster="{{ $video->getThumbnail() }}"--}}
                        poster="https://testwwdv2.s3.eu-west-1.amazonaws.com/thumbnails/1517254501EG1G2mqfLK.jpeg">
                    {{--<source src="{{ $video->getVideoUrl() }}" type="video/mp4" />--}}
                    <source src="https://testwwdv2.s3.eu-west-1.amazonaws.com/videos/1517254499bwOgWPUvSw.mp4" type="video/mp4" />
                </amp-video>
                <div class="video__description-container">
                    {{--                    <a class="video__avatar" href="{{ route('video.show', $video->slug) }}">--}}
                    <a class="video__avatar" href="https://wordswontdo.com/video/valentines">
                        <amp-img
                                {{--                            alt="{{ route('channel.index', $video->user->slug) }}"--}}
                                alt="image"
                                class="rounded-circle"
                                {{--                            src="{{ $video->user->thumbnail_path }}"--}}
                                src="https://testwwdv2.s3.eu-west-1.amazonaws.com/usersthumbnails/1517254556vwJusDq9u6.png"
                                height="75"
                                layout="responsive"
                                width="75">
                        </amp-img>
                    </a>
                    <div>
                        <h2 class="video__title">Valentines</h2>
                        <p class="video__author">
                            by: <a href="">Scenic</a>
                        </p>
                    </div>
                </div>
            </div>
            <div class="col-12 col-sm-10 col-lg-5 pt-lg-3">
                Buttons
            </div>
        </div>
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
