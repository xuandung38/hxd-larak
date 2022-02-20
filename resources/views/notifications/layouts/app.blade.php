<!doctype html>
<html lang="vi">
<head>
    <meta charset="utf-8"/>
    <link rel="apple-touch-icon" sizes="76x76" href="{{ asset('images/favicon.png') }}"/>
    <link rel="icon" type="image/png" href="{{ asset('images/favicon.png')  }}"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1"/>
    <title>@yield('title')</title>
    <meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0' name='viewport'/>
    <meta name="viewport" content="width=device-width"/>
    <link href="{{ asset('css/error_app.css') }}" rel="stylesheet"/>
</head>
<body>
@yield('content')
</body>
</html>
