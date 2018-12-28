<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>{{ config('app.name', 'Laravel') }} @yield('title')</title>
    <link rel="icon" type="img/ico" href="{{asset('images/favicon.ico')}}">

    <!-- Scripts -->
    <script src="{{ asset('js/modernizr.min.js') }}"></script>

    <!-- Fonts -->
    <link href='//fonts.googleapis.com/css?family=Rambla:400,700,400italic,700italic%7CLato:400,700%7CPoiret+One%7CTenor+Sans%7CJosefin+Sans:400,600,600italic%7CArizonia'
          rel='stylesheet' type='text/css'>

    <!-- Styles -->
    <link href="{{ asset('css/front.css') }}" rel="stylesheet">
    @yield('css')

    @if(env('APP_ENV') == 'production')
        <script async src="https://www.googletagmanager.com/gtag/js?id=UA-131352123-1"></script>
        <script>
            window.dataLayer = window.dataLayer || [];
            function gtag(){dataLayer.push(arguments);}
            gtag('js', new Date());

            gtag('config', 'UA-131352123-1');
        </script>
    @endif
</head>
<body class="panelsnap onepage flexheader">
@yield('content')
<script src="{{ asset('js/front.js') }}"></script>
@yield('js')
</body>
</html>
