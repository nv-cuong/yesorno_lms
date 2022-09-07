<!doctype html>
<html class="no-js" lang="zxx">

<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title> Team 5 | @yield('title') </title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('/user/img/logo/favicon.png') }}">

    <link href="{{ asset('/user/css/bootstrap.min.css') }}" rel="stylesheet" />
    <link href="{{ asset('/user/css/fontawesome.min.css') }}" rel="stylesheet" />
    <link href="{{ asset('/user/css/magnific-popup.css') }}" rel="stylesheet" />
    <link href="{{ asset('/user/css/owl.carousel.min.css') }}" rel="stylesheet" />
    <link href="{{ asset('/user/css/owl.theme.default.min.css') }}" rel="stylesheet" />
    <link href="{{ asset('/user/css/animate.css') }}" rel="stylesheet" />
    <link href="{{ asset('/user/css/bsnav.min.css') }}" rel="stylesheet" />
    <link href="{{ asset('/user/css/flaticon-set.css') }}" rel="stylesheet" />
    <link href="{{ asset('/user/css/site-animation.css') }}" rel="stylesheet" />
    <link href="{{ asset('/user/css/slick.css') }}" rel="stylesheet" />
    <link href="{{ asset('/user/css/themify-icons.css') }}" rel="stylesheet" />
    <link href="{{ asset('/user/css/swiper.min.css') }}" rel="stylesheet" />
    <link href="{{ asset('/user/style.css') }}" rel="stylesheet">
    <link href="{{ asset('/user/css/responsive.css') }}" rel="stylesheet" />
    @yield('css')
    <style>
        .pagination {
            height: auto;
            background-color: transparent;
        }

        .pagination li {
            display: inline-flex;
        }

        .desciption_course{
            display: -webkit-box;
            -webkit-line-clamp: 3;
            -webkit-box-orient: vertical;
            overflow: hidden;
            text-overflow: ellipsis;
            min-height: 90px;
            color: #000;
        }
        .desciption_course>p, .desciption_course>ul>li{
            color: #000;
        }
    </style>

</head>

<body class="demo-1" id="bdy">

    <div class="se-pre-con"></div>


    @include('client.layouts.header')
    <div class="clearfix"></div>


    @yield('content')
    <div class="clearfix"></div>
    @yield('js')
    @include('client.layouts.footer')
    <script src="{{ asset('/user/js/jquery-2.0.0.min.js') }}"></script>
    <script src="{{ asset('/user/js/jquery-1.12.4.min.js') }}"></script>
    <script src="{{ asset('/user/js/popper.min.js') }}"></script>
    <script src="{{ asset('/user/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('/user/js/jquery.appear.js') }}"></script>
    <script src="{{ asset('/user/js/html5/html5shiv.min.js') }}"></script>
    <script src="{{ asset('/user/js/html5/respond.min.js') }}"></script>
    <script src="{{ asset('/user/js/jquery.easing.min.js') }}"></script>
    <script src="{{ asset('/user/js/jquery.magnific-popup.min.js') }}"></script>
    <script src="{{ asset('/user/js/progress-bar.min.js') }}"></script>
    <script src="{{ asset('/user/js/modernizr.custom.13711.js') }}"></script>
    <script src="{{ asset('/user/js/owl.carousel.min.js') }}"></script>
    <script src="{{ asset('/user/js/wow.min.js') }}"></script>
    <script src="{{ asset('/user/js/isotope.pkgd.min.js') }}"></script>
    <script src="{{ asset('/user/js/imagesloaded.pkgd.min.js') }}"></script>
    <script src="{{ asset('/user/js/count-to.js') }}"></script>
    <script src="{{ asset('/user/js/fontawesome.min.js') }}"></script>
    <script src="{{ asset('/user/js/swiper.min.js') }}"></script>
    <script src="{{ asset('/user/js/text.js') }}"></script>
    <script src="{{ asset('/user/js/YTPlayer.min.js') }}"></script>
    <script src="{{ asset('/user/js/slick.min.js') }}"></script>
    <script src="{{ asset('/user/js/bsnav.min.js') }}"></script>
    <script src="{{ asset('/user/js/jquery.easypiechart.js') }}"></script>
    <script src="{{ asset('/user/js/main.js') }}"></script>
    @stack('scripts')
    @yield('scripts')
</body>

</html>
