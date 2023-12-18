<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" class="dark">

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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.6.1/cropper.min.css"
        integrity="sha512-hvNR0F/e2J7zPPfLC9auFe3/SE0yG4aJCOd/qxew74NN7eyiSKjr7xJJMu1Jy2wf7FXITpWS1E/RY8yzuXN7VA=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />

    <script type="text/javascript">
        // Fix for Firefox autofocus                     // See: http://stackoverflow.com/questions/18943276/html-5-autofocus-messes-up-css-loading/18945951#1951
    </script>
    <script type="text/javascript" src="https://js.pusher.com/7.0/pusher.min.js" defer></script>
    <script type="module" src={{ url('js/app.js') }}></script>
    <script type="module" src={{ url('js/toast.js') }}></script>
    <script type="module" src={{ url('js/general_helpers.js') }}></script>
    <script type="module" src={{ url('js/feedback.js') }}></script>
    <script type="module" src={{ url('js/ajax.js') }}></script>
    <script type="module" src={{ url('js/file_input.js') }}></script>
    <script type="module" src={{ url('js/network.js') }}></script>
    <script type="module" src={{ url('js/add_follow.js') }}></script>
    <script type="module" src={{ url('js/posts/post_helpers.js') }}></script>
    <script type="module" src={{ url('js/posts/add_comment.js') }}></script>
    <script type="module" src={{ url('js/posts/delete_post.js') }}></script>
    <script type="module" src={{ url('js/posts/edit_post.js') }}></script>
    <script type="module" src={{ url('js/posts/add_post.js') }}></script>
    <script type="module" src={{ url('js/posts/like.js') }}></script>
    <script type="module" src={{ url('js/search.js') }}></script>
    <script type="module" src={{ url('js/contact.js') }}></script>
    <script type="module" src={{ url('js/notifications.js') }}></script>
    <script type="module" src={{ url('js/settings.js') }}></script>
    <script type="module" src={{ url('js/group/group.js') }}></script>
    <script type="module" src={{ url('js/infinite_scrolling.js') }}></script>
    <script type="module" src={{ url('js/profile/profile_infinite_scrolling.js') }}></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.6.1/cropper.min.js"
        integrity="sha512-9KkIqdfN7ipEW6B6k+Aq20PV31bjODg4AA52W+tYtAE0jE0kMx49bjJ3FgvS56wzmyfMUHbQ4Km2b7l9+Y/+Eg=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://kit.fontawesome.com/3c619ea7f7.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11" defer></script>
    <script>
        const isAuthenticated = @json(auth() -> check());
    </script>
    @stack('scripts')
    @vite('resources/css/app.css')
    @vite('resources/js/app.js')
    @vite('resources/js/sweetalert.js')
</head>


<body class="   dark:bg-dark-primary dark:text-dark-secondary
                lg:px-[10vw]
                xl:px-[30vw]">

    @include('partials.toast')
    @include('partials.header')
    @yield('content')
    @include('partials.side.navbar')
    @include('partials.side.right-tab')

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