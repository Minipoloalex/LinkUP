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
    <script type="text/javascript">
        // Fix for Firefox autofocus CSS bug
        // See: http://stackoverflow.com/questions/18943276/html-5-autofocus-messes-up-css-loading/18945951#18945951
    </script>
    <script type="module" src={{ url('js/app.js') }} defer>
    </script>
    @vite('resources/css/app.css')
    @vite('resources/js/app.js')
</head>

<body class="px-8 h-screen flex flex-col">
    <header class="grid grid-cols-3">
        <div class="col-span-1 flex flex-wrap content-center justify-center border-gray-300 border-solid border-r">
            <a class="h-24" href="{{ url('/') }}">
                <img class="w-auto h-24" src="{{ url('images/logo.png') }}" alt="Logo">
            </a>
        </div>
        <div class="col-span-1 flex content-center flex-wrap justify-center flex-grow">
            <div class="w-9/12 flex content-center justify-center flex-grow">
                <form class="flex flex-row content-center justify-center mb-0 border-gray-300 border-solid border
                             px-2 py-1 rounded-full" action="{{ url('/search') }}" method="GET">
                    <input class="align-middle border-0 focus:outline-none" type="text" name="query">
                    <button class="align-middle" type="submit">
                        <img class="w-6 h-6" src="{{ url('images/search.png') }}" alt="Search">
                    </button>
                </form>
            </div>
        </div>
        <div class="flex content-center justify-center flex-wrap col-span-1 border-gray-300 border-solid border-l">
            <div>
                @guest
                <a href="{{ url('/login') }}">Login</a>
                @else
                <a href="{{ url('/profile') }}">
                    <img class="w-8 h-8" src="{{ url('images/profile.png') }}" alt="Profile">
                </a>
                @endguest
            </div>
        </div>
    </header>
    <main class="h-max grid grid-cols-3 border-solid border-teal-800 border-2 flex-grow">
        <nav class="col-span-1 flex content-center justify-center pl-16" id="left-tab">
            <div class="w-full flex py-1 pl-16 flex-col content-center justify-center">
                <div class="flex py-2 text-xl">
                    <a href="{{ url('/home') }}">Home</a>
                </div>
                <div class="flex py-2 text-xl">
                    <a href="{{ url('/profile') }}">Profile</a>
                </div>
                <div class="flex py-2 text-xl">
                    <a href="{{ url('/friends') }}">Friends</a>
                </div>
                <div class="flex py-2 text-xl">
                    <a href="{{ url('/groups') }}">Groups</a>
                </div>
                <div class="flex py-2 text-xl">
                    <a href="{{ url('/events') }}">Events</a>
                </div>
                <div class="flex py-2 text-xl">
                    <a href="{{ url('/settings') }}">Settings</a>
                </div>
            </div>
        </nav>
        <section class="col-span-1 flex flex-grow" id="content">
            @yield('content')
        </section>
        <section class="col-span-1 flex content-center justify-center pl-16" id="right-tab">
            <div class="w-full flex py-1 pl-16 flex-col content-center justify-center">
                <div class="flex py-2 text-xl">
                    <a href="{{ url('/notifications') }}">Notifications</a>
                </div>
                <div class="flex py-2 text-xl">
                    <a href="{{ url('/messages') }}">Messages</a>
                </div>
                <div class="flex py-2 text-xl">
                    <a href="{{ url('/friends') }}">Friends</a>
                </div>
                <div class="flex py-2 text-xl">
                    <a href="{{ url('/groups') }}">Groups</a>
                </div>
                <div class="flex py-2 text-xl">
                    <a href="{{ url('/events') }}">Events</a>
                </div>
            </div>
        </section>
    </main>
</body>

</html>