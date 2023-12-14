<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" class="dark">

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
    <script src="https://kit.fontawesome.com/3c619ea7f7.js" crossorigin="anonymous"></script>
    <script type="module" src={{ url('js/app.js') }} defer></script>
    <script type="module" src={{ url('js/auth.js') }} defer></script>
    @vite('resources/css/app.css')
    @vite('resources/js/app.js')
</head>

<body class="dark:bg-dark-primary dark:text-dark-secondary w-screen h-screen py-12">
    <img src="{{ url('images/logo-dark-mode.png') }}" alt="Link up logo" class="self-center w-48 mt-4">
    <div class="text-base font-bold text-center">
        <h1>A rede social da UPorto</h1>
    </div>
    @yield('content')
</body>

</html>