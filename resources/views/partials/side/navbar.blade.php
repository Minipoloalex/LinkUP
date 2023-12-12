@php
$authenticated = Auth::check();
$username = Auth::user()->username ?? "";
@endphp

<nav id="navbar"
    class=" fixed -bottom-1 left-0 w-full h-16 px-6 border-t-2 dark:bg-dark-primary dark:border-dark-neutral
            md:h-screen md:px-1 md:w-[10vw] md:top-0 md:left-0 md:border-0 md:border-r
            lg:top-0 lg:left-0 lg:h-screen lg:w-56 lg:flex lg:flex-col lg:items-center lg:justify-center lg:gap-8 lg:border-0 lg:pl-8">

    <ul class=" list-unstyled w-full h-full grid grid-cols-5 justify-items-center place-items-center
                md:flex md:flex-col md:gap-4 md:p-0 md:pt-[9rem]">

        <li class="md:w-12 md:h-12">
            <div class="flex w-full h-full items-center justify-center">
                <a href="{{ route('home') }}" class="md:h-full md:w-full md:flex md:items-center md:justify-center">
                    <i class="fa-solid fa-house fa-xl"></i>
                    <p class="hidden lg:block ml-4">Home</p>
                </a>
            </div>
        </li>
        <li class="md:w-12 md:h-12">
            <div class="flex w-full h-full items-center justify-center">
                <a href="{{ route('search') }}" class="md:h-full md:w-full md:flex md:items-center md:justify-center">
                    <i class="fa-solid fa-search fa-xl"></i>
                    <p class="hidden lg:block ml-4">Search</p>
                </a>
            </div>
        </li>
        @auth
        <li class=" w-9 h-9 flex items-center justify-center
                    md:w-12 md:h-12 md:p-1">
            <div class="flex w-full h-full rounded-full dark:bg-dark-active items-center justify-center">
                <i class="fa-solid fa-plus fa-xl"></i>
                <p class="hidden lg:block ml-4">Create</p>
            </div>
        </li>
        @endauth
        <li class="md:w-12 md:h-12">
            <div class="w-full h-full flex items-center justify-center">
                <a href="{{ $authenticated ? route('home') : route('login') }}">
                    <i class="fa-solid fa-bell fa-xl"></i>
                    <p class="hidden lg:block ml-4">Notifications</p>
                </a>
            </div>
        </li>
        <li class="md:w-12 md:h-12">
            <div class="w-full h-full flex items-center justify-center">
                <a href="{{  $authenticated ? url('/profile/' . $username) : route('login') }}"
                    class="md:h-full md:w-full md:flex md:items-center md:justify-center">
                    <i class="fa-solid fa-user fa-xl"></i>
                    <p class="hidden lg:block ml-4">Profile</p>
                </a>
            </div>
        </li>

        <li class="hidden md:flex md:w-12 md:h-12">
            <div class="flex items-center w-full justify-center">
                <a href="{{ $authenticated ? route('settings.show') : route('login') }}"
                    class="md:h-full md:w-full md:flex md:items-center md:justify-center">
                    <i class="fa-solid fa-gears fa-xl"></i>
                    <p class="hidden lg:block ml-4">Settings</p>
                </a>
            </div>
        </li>
    </ul>
</nav>