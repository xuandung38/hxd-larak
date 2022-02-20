<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="robots" content="noindex"/>

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- Locale -->
    <meta name="locale" content="{{ app()->getLocale() }}">

    <title>{{ config('app.name') }} Administrator System</title>

    <link rel="icon" type="image/png" href="{{asset('images/favicon.png')}}">

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700|Material+Icons" rel="stylesheet" type="text/css"/>

    <!-- Styles -->
    <link href="{{ asset('css/vendor/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/vendor/material-dashboard.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/vendor/element-ui.min.css') }}" rel="stylesheet">
    <link href="{{ mix('css/admin_app.css') }}" rel="stylesheet">

</head>
<body>
@include('admin.layouts.preloader')
<div class="wrapper" id="app">
    <side-bar
            :user="{{ json_encode($_user) }}"
            :system-role-id="{{ config('app.system_role_id') }}"
            :active-route="{{ json_encode($_activeRoute) }}"
    >
    </side-bar>
    <div class="main-panel">
        <nav-bar
                :breadcrumb="{{ json_encode($_breadcrumb) }}"
                :notifications="{{ json_encode($_notifications) }}"
        ></nav-bar>
        <div class="content">
            @yield('content')
        </div>
    </div>
</div>
<!-- Core JavaScript -->
<script src="{{ asset('js/vendor/jquery.min.js') }}"></script>

<!-- Material dashboard require -->
<script src="{{ asset('js/vendor/bootstrap.min.js') }}"></script>
<script src="{{ asset('js/vendor/bootstrap-tagsinput.min.js') }}"></script>
<script src="{{ asset('js/vendor/material-kit.min.js') }}"></script>
<script src="{{ asset('js/vendor/perfect-scrollbar.min.js') }}"></script>
<script src="{{ asset('js/vendor/material-dashboard.min.js') }}"></script>

<!-- Editor -->
<script src="{{ asset('vendor/ckeditor/ckeditor.js') }}"></script>

<!-- App -->
<script src="{{ mix('js/admin_app.js') }}" defer></script>
</body>
</html>
