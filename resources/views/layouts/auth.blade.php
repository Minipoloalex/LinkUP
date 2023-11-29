<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Styles -->
    <link href="{{ url('css/milligram.min.css') }}" rel="stylesheet">
    <link href="{{ url('css/app.css') }}" rel="stylesheet">
    <script type="module" src={{ url('js/app.js') }} defer></script>
    <script type="module" src={{ url('js/auth.js') }} defer></script>
    @vite('resources/css/app.css')
    @vite('resources/js/app.js')
</head>

<body class="lg:bg-slate-400">
    @yield('content')
</body>

</html>