@php
$authenticated = Auth::check();
$username = Auth::user()->username ?? "";
@endphp

<nav id="navbar" class=" fixed -bottom-2 left-0 w-full h-16 px-6 border-t-2 dark:bg-dark-primary dark:border-dark-neutral pb-2
            lg:h-screen lg:px-1 lg:w-[10vw] lg:top-0 lg:left-0 lg:border-0 lg:border-r
            xl:w-[30vw] xl:flex xl:justify-end">

    <ul class=" list-unstyled w-full h-full flex items-center justify-around
                lg:flex lg:flex-col lg:gap-4 lg:p-0 lg:pt-[9rem]
                xl:w-1/3 xl:items-start xl:justify-start xl:min-w-fit xl:mr-4">

        <li class="lg:w-12 lg:h-12 xl:w-full">
            <div class="flex w-full h-full items-center justify-center">
                <a href="{{ route('home') }}" class="   lg:h-full lg:w-full lg:flex lg:items-center lg:justify-center
                                                        xl:justify-start">
                    <div class="lg:w-8">
                        <i class="fa-solid fa-house fa-xl"></i>
                    </div>
                    <p class="hidden xl:block ml-4">Home</p>
                </a>
            </div>
        </li>
        <li class="lg:w-12 lg:h-12 xl:w-full">
            <div class="flex w-full h-full items-center justify-center">
                <a href="{{ route('search') }}" class=" lg:h-full lg:w-full lg:flex lg:items-center lg:justify-center 
                                                        xl:justify-start">
                    <div class="lg:w-8">
                        <i class="fa-solid fa-search fa-xl"></i>
                    </div>
                    <p class="hidden xl:block ml-4">Search</p>
                </a>
            </div>
        </li>
        <li class="lg:w-12 lg:h-12 xl:w-full">
            <div class="w-full h-full flex items-center justify-center">
                <a href="{{ $authenticated ? route('home') : route('login') }}" class=" lg:h-full lg:w-full lg:flex lg:items-center lg:justify-center 
                            xl:justify-start">
                    <div class="lg:w-8">
                        <i class="fa-solid fa-bell fa-xl"></i>
                    </div>
                    <p class="hidden xl:block ml-4">Notifications</p>
                </a>
            </div>
        </li>
        <li class="lg:w-12 lg:h-12 xl:w-full">
            <div class="w-full h-full flex items-center justify-center">
                <a href="{{  $authenticated ? url('/profile/' . $username) : route('login') }}"
                    class="lg:h-full lg:w-full lg:flex lg:items-center lg:justify-center xl:justify-start">
                    <div class="lg:w-8">
                        <i class="fa-solid fa-user fa-xl"></i>
                    </div>
                    <p class="hidden xl:block ml-4">Profile</p>
                </a>
            </div>
        </li>

        <li class="hidden lg:flex lg:w-12 lg:h-12 xl:w-full">
            <div class="flex items-center w-full justify-center">
                <a href="{{ $authenticated ? route('settings.show') : route('login') }}"
                    class="lg:h-full lg:w-full lg:flex lg:items-center lg:justify-center xl:justify-start">
                    <div class="lg:w-8">
                        <i class="fa-solid fa-gear fa-xl"></i>
                    </div>
                    <p class="hidden xl:block ml-4">Settings</p>
                </a>
            </div>
        </li>

        <li class="hidden lg:flex lg:w-12 lg:h-12 xl:w-full">
            <div class="flex items-center w-full justify-center">
                <a href="{{ $authenticated ? route('profile.network', ['username' => $username]) : route('login') }}"
                    class="lg:h-full lg:w-full lg:flex lg:items-center lg:justify-center xl:justify-start">
                    <div class="lg:w-8">
                        <i class="fa-solid fa-globe fa-xl"></i>
                    </div>
                    <p class="hidden xl:block ml-4">Network</p>
                </a>
            </div>
        </li>

        @auth
        <li class=" w-9 h-9 flex items-center justify-center
                    lg:w-12 lg:h-12 lg:p-1 xl:w-full xl:p-0">
            <div class="add-post-on flex w-full h-full rounded-full dark:bg-dark-active items-center justify-center 
                        xl:justify-center xl:items-center">
                <i class="fa-solid fa-plus fa-xl xl:hidden"></i>
                <p class="hidden ml-4 xl:block xl:m-0">Create</p>
            </div>
        </li>
        @endauth

        <div class="hidden lg:flex lg:flex-col lg:flex-grow lg:items-center lg:justify-end pb-8">
            <li class="hidden lg:flex lg:w-12 lg:h-12 xl:w-full">
                <div class="lg:flex lg:items-center lg:w-full lg:justify-center">
                    <a href="{{ route('about') }}"
                        class="lg:h-full lg:w-full lg:flex lg:items-center lg:justify-center xl:justify-start">
                        <div class="lg:w-8">
                            <i class="fa-regular fa-circle-question fa-xl"></i>
                        </div>
                        <p class="hidden xl:block xl:ml-4">About us</p>
                    </a>
                </div>
            </li>
        </div>
    </ul>
</nav>