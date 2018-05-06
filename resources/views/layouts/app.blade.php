<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}"></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Raleway:300,400,600" rel="stylesheet" type="text/css">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    @yield('css')
</head>
<body>
<div id="app">
    <!-- Modal -->
    <div id="pusherModal" class="modal fade" role="dialog">
        <div class="modal-dialog">

            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Alert</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <p id="pusherModalContent"></p>
                </div>
                <div class="modal-footer">
                    <a href="{{route('staff.booking')}}" class="btn btn-default">Check it now</a>
                </div>
            </div>

        </div>
    </div>

    <nav class="navbar navbar-expand-md navbar-light navbar-laravel">
        <div class="container">
            <a class="navbar-brand" href="{{ url('/') }}">
                {{ config('app.name', 'Laravel') }}
            </a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
                    aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
            @if(auth()->check())
                <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav mr-auto">
                        <li class="nav-item {{\request()->segment(2) == 'home' ? 'active' : ''}}">
                            <a class="nav-link" href="{{route('staff.home')}}">Dashboard</a>
                        </li>
                        <li class="nav-item {{\request()->segment(2) == 'booking' ? 'active' : ''}}">
                            <a class="nav-link" href="{{route('staff.booking')}}">Bookings</a>
                        </li>
                        <li class="nav-item {{\request()->segment(2) == 'customer' ? 'active' : ''}}">
                            <a class="nav-link" href="{{route('staff.customer')}}">Customers</a>
                        </li>
                        <li class="nav-item {{\request()->segment(2) == 'news' ? 'active' : ''}}">
                            <a class="nav-link" href="{{route('staff.news')}}">News</a>
                        </li>
                        <li class="nav-item {{\request()->segment(2) == 'gallery' ? 'active' : ''}}">
                            <a class="nav-link" href="{{route('staff.gallery')}}">Gallery</a>
                        </li>
                        <li class="nav-item {{\request()->segment(2) == 'service' ? 'active' : ''}}">
                            <a class="nav-link" href="{{route('staff.service')}}">Services</a>
                        </li>
                        <li class="nav-item {{\request()->segment(2) == 'stylist' ? 'active' : ''}}">
                            <a class="nav-link" href="{{route('staff.stylist')}}">Stylist</a>
                        </li>
                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ml-auto">
                        <!-- Authentication Links -->
                        <li class="nav-item dropdown">
                            <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button"
                               data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                {{ Auth::user()->name }} <span class="caret"></span>
                            </a>

                            <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                                <a class="dropdown-item" href="{{ route('staff.logout') }}"
                                   onclick="event.preventDefault();
                                                    document.getElementById('logout-form').submit();">
                                    Logout
                                </a>

                                <form id="logout-form" action="{{ route('staff.logout') }}" method="POST"
                                      style="display: none;">
                                    @csrf
                                </form>
                            </div>
                        </li>
                    </ul>
                @endif
            </div>
        </div>
    </nav>

    <main class="py-4">
        @yield('content')
    </main>

    <audio id="alertAudio">
        <source src="{{asset('alert.ogg')}}" type="audio/ogg">
        <source src="{{asset('alert.mp3')}}" type="audio/mpeg">
        Your browser does not support the audio element.
    </audio>
</div>

@if(auth()->check() && !empty(env('PUSHER_APP_KEY')))
    <script src="https://js.pusher.com/4.1/pusher.min.js"></script>
    <script>
        @if(env('APP_ENV') != 'production')
        // Enable pusher logging - don't include this in production
        Pusher.logToConsole = true;
        @endif

        var pusher = new Pusher('{{env('PUSHER_APP_KEY')}}', {
                cluster: '{{env('PUSHER_APP_CLUSTER')}}',
                encrypted: true
            });

        var channel = pusher.subscribe('booking');
        channel.bind('new', function(data) {
            alertSound = document.getElementById("alertAudio");
            $('#pusherModal').modal('show');
            $("#pusherModalContent").text(data.message);
            alertSound.play();
        });
    </script>
@endif

<script>
    $('div.alert').not('.alert-important').delay(3000).fadeOut(350);
</script>
@yield('js')
</body>
</html>
