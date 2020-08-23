<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Administrator - Terrell Davies</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">
        <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
        <link rel="shortcut icon" href="{{ asset('images/fav.png') }}">

        {{-- Login Style --}}
        <link rel="stylesheet" type="text/css" href="{{ asset('login/vendor/bootstrap/css/bootstrap.min.css') }}">
        <link rel="stylesheet" type="text/css" href="{{ asset('login/fonts/font-awesome-4.7.0/css/font-awesome.min.css') }}">
        <link rel="stylesheet" type="text/css" href="{{ asset('login/fonts/iconic/css/material-design-iconic-font.min.css') }}">
        <link rel="stylesheet" type="text/css" href="{{ asset('login/vendor/animate/animate.css') }}">
        <link rel="stylesheet" type="text/css" href="{{ asset('login/vendor/animsition/css/animsition.min.css') }}">
        <link rel="stylesheet" type="text/css" href="{{ asset('login/css/util.css') }}">
        <link rel="stylesheet" type="text/css" href="{{ asset('login/css/main.css') }}">

    </head>
    <body>
       <div id="app">
        </div>

         <script src="/js/app.js"></script>
         <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.23.0/moment.js"></script>
         <script src="{{ asset('login/vendor/jquery/jquery-3.2.1.min.js') }}"></script>
        <script src="{{ asset('login/vendor/animsition/js/animsition.min.js') }}"></script>
        <script src="{{ asset('login/vendor/bootstrap/js/popper.js') }}"></script>
        <script src="{{ asset('login/vendor/bootstrap/js/bootstrap.min.js') }}"></script>
        <script src="{{ asset('login/vendor/daterangepicker/moment.min.js') }}"></script>
        <script src="{{ asset('login/js/main.js') }}"></script>
    </body>
</html>
