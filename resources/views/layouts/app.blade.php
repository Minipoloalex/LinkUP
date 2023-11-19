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
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css">

        <script type="text/javascript">
            // Fix for Firefox autofocus CSS bug
            // See: http://stackoverflow.com/questions/18943276/html-5-autofocus-messes-up-css-loading/18945951#18945951
        </script>
        <script type="text/javascript" src={{ url('js/app.js') }} defer>
        </script>

        @vite('resources/css/app.css')
    </head>
    <body>
        <main>
            <!-- header should be floating, with round corner and grey background using tailwind -->
            <header class="header">
                <h1><a href="{{ url('/cards') }}">LOGO DA EMPRESA</a></h1>
                <div class="search-bar">
                    <button type="submit" class="search-button"><i class="fa fa-search"></i></button>
                    <input type="search" name="q" placeholder="Search">
                </div>

                @if (Auth::check())
                    <a class="button" href="{{ route('profile', ['email' => Auth::user()->email]) }}">Profile</a>
                    <!-- <a class="button" href="{{ url('/logout') }}"> Logout </a> <span>{{ Auth::user()->name }}</span> -->
                @endif
            </header>

            <section id="content">
              @yield('profile-page')
          </section> 
        </main>
  
    </body>
</html>