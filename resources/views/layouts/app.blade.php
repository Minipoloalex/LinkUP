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
    <link href="{{ url('css/posts.css') }}" rel="stylesheet">
    <script type="text/javascript">
        // Fix for Firefox autofocus CSS bug
        // See: http://stackoverflow.com/questions/18943276/html-5-autofocus-messes-up-css-loading/18945951#18945951
    </script>
    {{--
    <script type="module" src={{ url('js/app.js') }}></script> --}}
    <script type="text/javascript" src={{ url('js/ajax.js') }} defer></script>
    <script type="text/javascript" src={{ url('js/file_input.js') }} defer></script>
    <script type="text/javascript" src={{ url('js/post_helpers.js') }} defer></script>
    <script type="text/javascript" src={{ url('js/post_render.js') }} defer></script>
    <script type="text/javascript" src={{ url('js/app.js') }} defer></script>
    <script type="text/javascript" src={{ url('js/add_comment.js') }} defer></script>
    <script type="text/javascript" src={{ url('js/delete_post.js') }} defer></script>
    <script type="text/javascript" src={{ url('js/search.js') }} defer></script>
    <script type="text/javascript" src={{ url('js/edit_post.js') }} defer></script>
    <script type="text/javascript" src={{ url('js/add_post.js') }} defer></script>
    @vite('resources/css/app.css')
    @vite('resources/js/app.js')
</head>

<body class="mx-64 h-screen flex flex-col bg-white">
    @include('partials.header')
    @yield('content')
</body>

</html>