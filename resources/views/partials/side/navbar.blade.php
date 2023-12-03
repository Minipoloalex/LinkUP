@php
$authenticated = Auth::check();
$username = Auth::user()->username ?? "";
@endphp

<nav class="fixed bottom-0 left-0 w-full h-16 grid grid-cols-5 items-center px-8 bg-white border-t border-slate-400
            md:flex md:flex-col md:justify-center md:h-screen md:w-16 md:gap-8 md:px-0 lg:w-56 lg:border-0 lg:pl-8"
        id="navbar">
    <ul class="list-unstyled">
        <li class="lg:w-full md:flex md:h-12 md:items-center">
            <a href="{{ route('home') }}">
                <div class="flex w-full items-center justify-center">
                    <i class="fa-solid fa-house fa-xl"></i>
                    <p class="hidden lg:block ml-4">Home</p>
                </div>
            </a>
        </li>
        <li class="lg:w-full md:flex md:h-12 md:items-center">
            <a href="{{ route('search') }}">
                <div class="flex w-full items-center justify-center">
                    <i class="fa-solid fa-search fa-xl"></i>
                    <p class="hidden lg:block ml-4">Search</p>
                </div>
            </a>
        </li>
        @auth
            <li class="lg:w-full md:flex md:h-12 md:items-center">
                <div class="block add-post-on">
                    <div class="flex w-full items-center justify-center">
                        <i class="fa-solid fa-plus fa-xl"></i>
                        <p class="hidden lg:block ml-4">Create</p>
                    </div>
                </div>
            </li>
        @endauth
        <li class="lg:w-full md:flex md:h-12 md:items-center">
            <a href="{{ $authenticated ? route('home') : route('login') }}">
                <div class="flex w-full items-center justify-center">
                    <i class="fa-solid fa-bell fa-xl"></i>
                    <p class="hidden lg:block ml-4">Notifications</p>
                </div>
            </a>
        </li>
        <li class="lg:w-full md:flex md:h-12 md:items-center">
            <a href="{{  $authenticated ? url('/profile/' . $username) : route('login') }}">
                <div class="flex items-center w-full justify-center">
                    <i class="fa-solid fa-user fa-xl"></i>
                    <p class="hidden lg:block ml-4">Profile</p>
                </div>
            </a>
        </li>
    </ul>
</nav>