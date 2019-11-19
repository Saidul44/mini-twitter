<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="{{ asset('/js/jasny-bootstrap.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('/js/sweetalert.min.js') }}" type="text/javascript"></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->

    @yield('style')

    <link href="{{ asset('css/style.css') }}" rel="stylesheet">
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">

    <link href="{{ asset('/css/sweetalert.css') }}" rel="stylesheet" type="text/css" />

    <link href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">

    <link href="{{ asset('css/jasny-bootstrap.min.css') }}" rel="stylesheet">
    <!-- <link href="https://cdnjs.cloudflare.com/ajax/libs/jasny-bootstrap/4.0.0/css/jasny-bootstrap.min.css" rel="stylesheet"> -->

</head>
<body>
    <div id="app">
        
        @if(Auth::guest() && ( \Request::is('login') || \Request::is('register'))) 

            @include('layouts.partials.nav.top_nav')

            <main class="py-4">
                @yield('content')
            </main>

        @else
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-3">
                        @include('layouts.partials.nav.left_nav')
                    </div>
                    <div class="col-md-9">
                        @yield('content')
                    </div>
                </div>
            </div>
        @endif
    </div>

    @if(Auth::check())
        @include('common_layout.post_modal')
    @endif

    @include('common_layout.post_comment_function')

    @yield('script')


</body>
</html>
