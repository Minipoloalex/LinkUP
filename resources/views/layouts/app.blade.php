<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- font awesome -->
    <!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css"> -->


    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Styles -->
    <link href="{{ url('css/milligram.min.css') }}" rel="stylesheet">
    <link href="{{ url('css/app.css') }}" rel="stylesheet">
    <script type="text/javascript">
        // Fix for Firefox autofocus CSS bug
        // See: http://stackoverflow.com/questions/18943276/html-5-autofocus-messes-up-css-loading/18945951#18945951
    </script>
    <script type="module" src={{ url('js/app.js') }} defer></script>
    <script type="text/javascript" src={{ url('js/file_input.js') }} defer></script>
    <script type="text/javascript" src={{ url('js/post_helpers.js') }} defer></script>
    <script type="text/javascript" src={{ url('js/add_comment.js') }} defer></script>
    <script type="text/javascript" src={{ url('js/delete_post.js') }} defer></script>
    <script type="text/javascript" src={{ url('js/search.js') }} defer></script>
    <script type="text/javascript" src={{ url('js/edit_post.js') }} defer></script>
    <script type="text/javascript" src={{ url('js/add_post.js') }} defer></script>
    @vite('resources/css/app.css')
    @vite('resources/js/app.js')
</head>

<body class="px-64 h-screen flex flex-col">
    @include('partials.header')
    @yield('content')
</body>
</html>