<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script src="https://unpkg.com/mic-recorder-to-mp3@2.2.1/dist/index.js"></script>
    <title>{{ config('app.name', 'Laravel') }}</title>
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
    <!-- Fonts -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.3/font/bootstrap-icons.css">
    <!-- Scripts -->
    <link rel="stylesheet" href="{{ URL::asset('css/style.css') }}">
    <style>
        .pageLoader {
            position: fixed;
            top: 0;
            left: 0;
            height: 100%;
            width: 100%;
            z-index: 9999999;
            background-color: #ffffff;
            display: flex;
            align-items: center;
            justify-content: center;
        }
    </style>
</head>

<body>
    <div class="pageLoader" id="pageLoader">
        <img src="{{ URL::asset('images/load2.svg') }}" alt="">
    </div>
    <div id="app">

        @yield('navbar')
        @yield('content')

    </div>
    <script>
        $(window).on('beforeunload', function() {
            $('#pageLoader').show();
        });
        $(function() {
            $('#pageLoader').hide();
        })
    </script>
</body>

</html>
