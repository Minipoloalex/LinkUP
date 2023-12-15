<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="is-admin" content="">
    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Styles -->
    <link href="{{ url('css/app.css') }}" rel="stylesheet">
    <script src="https://kit.fontawesome.com/3c619ea7f7.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11" defer></script>
    <script type="module" src="{{ url('js/posts/delete_post.js')}}"></script>
    <script type="module" src="{{ url('js/admin/users.js')}}"></script>
    <script type="module" src="{{ url('js/admin/posts.js')}}"></script>
    <script type="module" src="{{ url('js/admin/groups.js')}}"></script>
    @vite('resources/css/app.css')
    @vite('resources/js/app.js')
</head>

<body class="h-screen w-2/3 flex flex-col mx-auto">
    <header class="flex content-center justify-between items-center px-6 py-4">
        <a href="{{ url('admin/dashboard') }}">
            <img src="{{ url('images/logo.png') }}" alt="Link up logo" class="w-24">
        </a>
        <div class="w-42">
            <h1 class="text-2xl">Admin Dashboard</h1>
        </div>
        <div class="w-24">
            <a href="{{ route('logout') }}" class="text-slate-200 hover:text-white">
                <img src="{{ url('images/icons/logout.png') }}" alt="Logout" class="w-6">
            </a>
        </div>
    </header>
    @yield('content')
</body>

</html>