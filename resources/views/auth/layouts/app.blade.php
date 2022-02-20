<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- Locale -->
    <meta name="locale" content="{{ app()->getLocale() }}">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1"/>
    <meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0' name='viewport'/>
    <link rel="apple-touch-icon" sizes="76x76" href="{{ asset('images/favicon.png') }}"/>
    <link rel="icon" type="image/png" href="{{ asset('images/favicon.png')  }}"/>

    <title>@yield('title')</title>

    <link href="{{ asset('css/vendor/bootstrap.min.css') }}" rel="stylesheet"/>
    <link href="{{ asset('css/vendor/material-dashboard.min.css') }}" rel="stylesheet"/>
    <link rel="stylesheet" href="{{ asset('css/vendor/element-ui.min.css') }}" type="text/css">
    <link href="{{ mix('css/auth_app.css') }}" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700|Material+Icons" rel="stylesheet">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
</head>
<body>
<div id="app">
    @yield('content')
</div>
<script src="{{ asset('js/vendor/jquery.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('js/vendor/bootstrap.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('js/vendor/material-kit.min.js') }}" type="text/javascript"></script>
<script src="{{ mix('js/auth_app.js') }}" type="text/javascript"></script>
</body>
</html>
