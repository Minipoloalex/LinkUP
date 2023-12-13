@php
$authenticated = Auth::check();
$username = Auth::user()->username ?? "";
@endphp

<nav id="navbar" class=" fixed -bottom-2 left-0 w-full h-16 px-6 border-t-2 dark:bg-dark-primary dark:border-dark-neutral pb-2
            md:h-screen md:px-1 md:w-[10vw] md:top-0 md:left-0 md:border-0 md:border-r
            lg:w-[30vw] lg:flex lg:justify-end">

    <ul class=" list-unstyled w-full h-full flex items-center justify-around
                md:flex md:flex-col md:gap-4 md:p-0 md:pt-[9rem]
                lg:w-1/3 lg:items-start lg:justify-start lg:min-w-fit lg:mr-4">

        <li class="md:w-12 md:h-12 lg:w-full">
            <div class="flex w-full h-full items-center justify-center">
                <a href="{{ route('home') }}" class="   md:h-full md:w-full md:flex md:items-center md:justify-center
                                                        lg:justify-start">
                    <div class="md:w-8">
                        <i class="fa-solid fa-house fa-xl"></i>
                    </div>
                    <p class="hidden lg:block ml-4">Home</p>
                </a>
            </div>
        </li>
        <li class="md:w-12 md:h-12 lg:w-full">
            <div class="flex w-full h-full items-center justify-center">
                <a href="{{ route('search') }}" class=" md:h-full md:w-full md:flex md:items-center md:justify-center 
                                                        lg:justify-start">
                    <div class="md:w-8">
                        <i class="fa-solid fa-search fa-xl"></i>
                    </div>
                    <p class="hidden lg:block ml-4">Search</p>
                </a>
            </div>
        </li>
        <li class="md:w-12 md:h-12 lg:w-full">
            <div class="w-full h-full flex items-center justify-center">
                <a href="{{ $authenticated ? route('home') : route('login') }}" class=" md:h-full md:w-full md:flex md:items-center md:justify-center 
                            lg:justify-start">
                    <div class="md:w-8">
                        <i class="fa-solid fa-bell fa-xl"></i>
                    </div>
                    <p class="hidden lg:block ml-4">Notifications</p>
                </a>
            </div>
        </li>
        <li class="md:w-12 md:h-12 lg:w-full">
            <div class="w-full h-full flex items-center justify-center">
                <a href="{{  $authenticated ? url('/profile/' . $username) : route('login') }}"
                    class="md:h-full md:w-full md:flex md:items-center md:justify-center lg:justify-start">
                    <div class="md:w-8">
                        <i class="fa-solid fa-user fa-xl"></i>
                    </div>
                    <p class="hidden lg:block ml-4">Profile</p>
                </a>
            </div>
        </li>

        <li class="hidden md:flex md:w-12 md:h-12 lg:w-full">
            <div class="flex items-center w-full justify-center">
                <a href="{{ $authenticated ? route('settings.show') : route('login') }}"
                    class="md:h-full md:w-full md:flex md:items-center md:justify-center lg:justify-start">
                    <div class="md:w-8">
                        <i class="fa-solid fa-gears fa-xl"></i>
                    </div>
                    <p class="hidden lg:block ml-4">Settings</p>
                </a>
            </div>
        </li>

        <li class="hidden md:flex md:w-12 md:h-12 lg:w-full">
            <div class="flex items-center w-full justify-center">
                <a href="{{ $authenticated ? route('profile.network', ['username' => $username]) : route('login') }}"
                    class="md:h-full md:w-full md:flex md:items-center md:justify-center lg:justify-start">
                    <div class="md:w-8">
                        <i class="fa-solid fa-globe fa-xl"></i>
                    </div>
                    <p class="hidden lg:block ml-4">Network</p>
                </a>
            </div>
        </li>

        @auth
        <li class=" w-9 h-9 flex items-center justify-center
                    md:w-12 md:h-12 md:p-1 lg:w-full lg:p-0">
            <div class="flex w-full h-full rounded-full dark:bg-dark-active items-center justify-center 
                        lg:justify-center lg:items-center">
                <i class="fa-solid fa-plus fa-xl lg:hidden"></i>
                <p class="hidden ml-4 lg:block lg:m-0">Create</p>
            </div>
        </li>
        @endauth

        <div class="hidden md:flex md:flex-col md:flex-grow md:items-center md:justify-end pb-8">
            <li class="hidden md:flex md:w-12 md:h-12 lg:w-full">
                <div class="md:flex md:items-center md:w-full md:justify-center">
                    <a href="{{ route('about') }}"
                        class="md:h-full md:w-full md:flex md:items-center md:justify-center lg:justify-start">
                        <div class="md:w-8">
                            <i class="fa-regular fa-circle-question fa-xl"></i>
                        </div>
                        <p class="hidden lg:block lg:ml-4">About us</p>
                    </a>
                </div>
            </li>
        </div>
    </ul>
</nav>