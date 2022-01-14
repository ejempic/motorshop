<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}?v={{now()}}" defer></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link rel="stylesheet" href="/css/app.css?v={{now()}}">
    <link rel="stylesheet" href="/font-awesome/css/font-awesome.css?v={{now()}}">
    <link rel="stylesheet" href="/css/template/animate.css?v={{now()}}">
    <link rel="stylesheet" href="/css/template/style.css?v={{now()}}">

</head>
<body class="gray-bg">
        @yield('content')
</body>
</html>
