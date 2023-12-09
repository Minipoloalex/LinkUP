@php
$authenticated = Auth::check();
$username = Auth::user()->username ?? "";
@endphp

<nav class="fixed bottom-0 left-0 w-full h-16 px-6 border-t
    dark:bg-dark-primary dark:border-dark-neutral
    md:top-0 md:left-0 md:h-screen md:w-16 md:flex md:flex-col md:items-center md:justify-center md:gap-8 md:px-0
    lg:top-0 lg:left-0 lg:h-screen lg:w-56 lg:flex lg:flex-col lg:items-center lg:justify-center lg:gap-8 lg:border-0 lg:pl-8"
    id="navbar">
    <ul class="list-unstyled w-full h-full grid grid-cols-5 justify-items-center place-items-center">
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
        <li class="w-9 h-9 flex items-center justify-center
        lg:w-full md:flex md:h-12 md:items-center">
            <div class="flex w-full h-full rounded-full dark:bg-dark-active items-center justify-center">
                <i class="fa-solid fa-plus fa-xl"></i>
                <p class="hidden lg:block ml-4">Create</p>
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

        <li class="hidden lg:w-full md:flex md:h-12 md:items-center">
            <a href="{{ $authenticated ? route('settings.show') : route('login') }}">
                <div class="flex items-center w-full justify-center">
                    <i class="fa-solid fa-gears fa-xl"></i>
                    <p class="hidden lg:block ml-4">Settings</p>
                </div>
            </a>
        </li>
    </ul>
</nav>