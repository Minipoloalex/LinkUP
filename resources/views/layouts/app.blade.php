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
                    <button type="submit" class="search-button"><i class="fas fa-search"></i></button>
                    <input type="search" name="q" placeholder="Search">
                </div>

                @if (Auth::check())
                    <a class="button" href="{{ route('profile', ['email' => Auth::user()->email]) }}">Profile</a>
                    <!-- <a class="button" href="{{ url('/logout') }}"> Logout </a> <span>{{ Auth::user()->name }}</span> -->
                @endif
            </header>
  
            <section id="content">
              @yield('content')
          </section> 
           
        </main>

        <div class="columns">
            <div class="column-1">
                <ul>
                    <li>Home</li>
                    <li>Profile</li>
                    <li>Following</li>
                    <li>Followers</li>
                    <li>Groups</li>
             
                    <li>About us</li>
                    <li>Support</li>
                   
                </ul>
            </div>
            <div class="column-2">
                <div>
                    <button type="button" class="edit-button">
                        <i class="fas fa-edit"></i>
                    </button>
                    <img src="https://i.pinimg.com/originals/9b/47/a0/9b47a023caf29f113237d61170f34ad9.jpg" alt="Profile Photo">
                </div>
                <div>
                    Content 2
                </div>
                <div>
                    Content 3
                </div>
            </div>
            <div class="column-3">
                <div>
                    Content 4
                </div>
            </div>
    </body>
</html>