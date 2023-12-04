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
    <link href="{{ url('css/app.css') }}" rel="stylesheet">
    <link href="{{ url('css/posts.css') }}" rel="stylesheet">
    <link href="{{ url('css/follow.css') }}" rel="stylesheet">
    <script type="module" src={{ url('js/feedback.js') }} defer></script>
    <script type="module" src={{ url('js/general_helpers.js') }} defer></script>
    <script type="module" src={{ url('js/ajax.js') }} defer></script>
    <script type="module" src={{ url('js/file_input.js') }} defer></script>
    <script type="module" src={{ url('js/network.js') }} defer></script>
    <script type="module" src={{ url('js/add_follow.js') }} defer></script>
    <script type="module" src={{ url('js/post_helpers.js') }} defer></script>
    <script type="module" src={{ url('js/post_render.js') }} defer></script>
    <script type="module" src={{ url('js/app.js') }} defer></script>
    <script type="module" src={{ url('js/add_comment.js') }} defer></script>
    <script type="module" src={{ url('js/delete_post.js') }} defer></script>
    <script type="module" src={{ url('js/search.js') }} defer></script>
    <script type="module" src={{ url('js/edit_post.js') }} defer></script>
    <script type="module" src={{ url('js/add_post.js') }} defer></script>
    <script type="module" src={{ url('js/edit_profile.js') }} defer></script>
    <script type="module" src={{ url('js/contact.js') }} defer></script>
    <script type="module" src={{ url('js/settings.js') }} defer></script>
    <script type="module" src={{ url('js/group/group.js') }} defer></script>
    <script type="module" src={{ url('js/like.js') }} defer></script>
    <script src="https://kit.fontawesome.com/3c619ea7f7.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11" defer></script>
    @vite('resources/css/app.css')
    @vite('resources/js/app.js')
</head>

<body>
    @include('partials.header')
    @yield('content')

    @php
    $isHidden = isset($feedbackMessage) ? '' : 'hidden';
    @endphp
    <footer id="feedback-message" class="{{$isHidden}} fixed bottom-5 w-1/2 transform -translate-x-1/2 left-1/2">
        <p id="feedback-text" class="text-center bg-gray-200 px-10 rounded py-2 text-gray-700 text-lg font-bold">
            @if (isset($feedbackMessage))
            {{ $feedbackMessage }}
            @endif
        </p>
        <button id="dismiss-feedback" class="inline absolute right-3 top-1/4">X</button>
    </footer>
</body>

</html>