<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" class="dark">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="is-admin" content="">
    <title>{{ config('app.name', 'Laravel') }} Admin - @yield('title')</title>

    <!-- Styles -->
    <link href="{{ url('css/app.css') }}" rel="stylesheet">
    <script src="https://kit.fontawesome.com/3c619ea7f7.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11" defer></script>
    <script type="module" src="{{ url('js/app.js') }}"></script>
    <script type="module" src="{{ url('js/toast.js') }}"></script>
    <script type="module" src="{{ url('js/feedback.js') }}"></script>
    <script type="module" src="{{ url('js/posts/delete_post.js')}}"></script>
    <script type="module" src="{{ url('js/admin/users.js')}}"></script>
    <script type="module" src="{{ url('js/admin/posts.js')}}"></script>
    <script type="module" src="{{ url('js/admin/groups.js')}}"></script>

    @stack('scripts')

    @vite('resources/css/app.css')
    @vite('resources/js/app.js')
</head>

<body class="h-screen w-2/3 flex flex-col mx-auto bg-dark-primary text-dark-secondary">
    <header class="flex content-center justify-between items-center px-6 py-4 h-24">
        <a href="{{ url('admin/dashboard') }}" class="flex">
            <img src="{{ url('images/logo-dark-mode.png') }}" alt="Link up logo" class="h-auto w-32">
        </a>
        <div class="flex items-center justify-center">
            <h1 class="text-2xl">Admin Dashboard</h1>
        </div>
        <div class="w-32 flex items-center justify-center">
            <a href="{{ route('logout') }}" class="text-dark-active">
                <i class="fas fa-sign-out-alt fa-xl"></i>
            </a>
        </div>
    </header>
    @yield('content')

    @include('partials.feedback')
</body>

</html>