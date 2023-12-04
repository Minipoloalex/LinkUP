<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @auth
        <meta name="user-id" content="{{ Auth::user()->id }}">
    @endauth
    <title>{{ config('app.name', 'Laravel') }} @yield('title')</title>

    <!-- Styles -->
    <link href="{{ url('css/app.css') }}" rel="stylesheet">
    <link href="{{ url('css/posts.css') }}" rel="stylesheet">
    <link href="{{ url('css/follow.css') }}" rel="stylesheet">
    <link href="{{ mix('node_modules/cropperjs/dist/cropper.css')}}" rel="stylesheet">

    <script type="text/javascript">
        // Fix for Firefox autofocus CSS bug
        // See: http://stackoverflow.com/questions/18943276/html-5-autofocus-messes-up-css-loading/18945951#18945951
    </script>
    <script type="text/javascript" src="{{ mix('node_modules/cropperjs/dist/cropper.js') }}" defer></script>
    <script type="text/javascript" src="https://js.pusher.com/7.0/pusher.min.js" defer></script>    
    <script type="module" src={{ url('js/general_helpers.js') }} defer></script>
    <script type="module" src={{ url('js/feedback.js') }} defer></script>
    <script type="module" src={{ url('js/ajax.js') }} defer></script>
    <script type="module" src={{ url('js/file_input.js') }} defer></script>
    <script type="module" src={{ url('js/network.js') }} defer></script>
    <script type="module" src={{ url('js/add_follow.js') }} defer></script>
    <script type="module" src={{ url('js/posts/post_helpers.js') }} defer></script>
    <script type="module" src={{ url('js/posts/post_render.js') }} defer></script>
    <script type="module" src={{ url('js/posts/add_comment.js') }} defer></script>
    <script type="module" src={{ url('js/posts/delete_post.js') }} defer></script>
    <script type="module" src={{ url('js/posts/edit_post.js') }} defer></script>
    <script type="module" src={{ url('js/posts/add_post.js') }} defer></script>
    <script type="module" src={{ url('js/posts/like.js') }} defer></script>
    <script type="module" src={{ url('js/search.js') }} defer></script>
    <script type="module" src={{ url('js/edit_profile.js') }} defer></script>
    <script type="module" src={{ url('js/contact.js') }} defer></script>
    <script type="module" src={{ url('js/notifications.js') }} defer></script>
    <script type="module" src={{ url('js/settings.js') }} defer></script>
    <script type="module" src={{ url('js/group/group.js') }} defer></script>
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