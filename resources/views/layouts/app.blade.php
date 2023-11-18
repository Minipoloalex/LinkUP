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
</head>

<body>
    <header>
        <nav class="top-nav">
            <div class="top-nav-logo">
                <a href="{{ url('/') }}">LinkUP</a>
            </div>
            <div class="top-nav-search">
                <div class="search-container">
                    <form action="{{ url('/search') }}" method="GET">
                        <input type="text" placeholder="Search.." name="query">
                        <button type="submit">Search</button>
                    </form>
                </div>
            </div>
            <div class="top-nav-user">
                <div class="user-container">
                    @guest
                    <a href="{{ url('/login') }}">Login</a>
                    <a href="{{ url('/register') }}">Register</a>
                    @else
                    <a href="{{ url('/profile') }}">Profile</a>
                    <a href="{{ url('/logout') }}">Logout</a>
                    @endguest
                </div>
            </div>
        </nav>
    </header>
    <main>
        <section id="left-tab">
            <div class="left-tab-container">
                <div class="left-tab-item">
                    <a href="{{ url('/home') }}">Home</a>
                </div>
                <div class="left-tab-item">
                    <a href="{{ url('/profile') }}">Profile</a>
                </div>
                <div class="left-tab-item">
                    <a href="{{ url('/friends') }}">Friends</a>
                </div>
                <div class="left-tab-item">
                    <a href="{{ url('/groups') }}">Groups</a>
                </div>
                <div class="left-tab-item">
                    <a href="{{ url('/events') }}">Events</a>
                </div>
                <div class="left-tab-item">
                    <a href="{{ url('/settings') }}">Settings</a>
                </div>
            </div>
        </section>
        <section id="content">
            @yield('content')
        </section>
        <section id="right-tab">
            <div class="right-tab-container">
                <div class="right-tab-item">
                    <a href="{{ url('/notifications') }}">Notifications</a>
                </div>
                <div class="right-tab-item">
                    <a href="{{ url('/messages') }}">Messages</a>
                </div>
                <div class="right-tab-item">
                    <a href="{{ url('/friends') }}">Friends</a>
                </div>
                <div class="right-tab-item">
                    <a href="{{ url('/groups') }}">Groups</a>
                </div>
                <div class="right-tab-item">
                    <a href="{{ url('/events') }}">Events</a>
                </div>
            </div>
        </section>
    </main>
</body>

</html>