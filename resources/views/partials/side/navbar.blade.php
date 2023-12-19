@php
$authenticated = Auth::check();
$username = Auth::user()->username ?? "";
$activePage ??= null;
$activeClass = 'dark:text-dark-active';
@endphp

<nav id="navbar" class=" fixed -bottom-2 left-0 w-full h-16 px-6 border-t-2 dark:bg-dark-primary dark:border-dark-neutral pb-2 z-[2]
            lg:h-screen lg:px-1 lg:w-[10vw] lg:top-0 lg:left-0 lg:border-0 lg:border-r
            xl:w-[30vw] xl:flex xl:justify-end">

    <ul class=" list-unstyled w-full h-full flex items-center justify-around
                lg:flex lg:flex-col lg:gap-4 lg:p-0 lg:pt-[9rem]
                xl:w-1/3 xl:items-start xl:justify-start xl:min-w-fit xl:mr-4">

        <li class="hidden lg:block lg:w-12 lg:h-12 xl:w-full @if ($activePage == 'home') {{$activeClass}} @endif">
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

        <li id="mobile-show-sidebar" class="block lg:hidden">
            <div class="block w-full h-full items-center justify-center">
                <i class="fa-solid fa-bars fa-xl"></i>
            </div>
        </li>

        <li class="lg:w-12 lg:h-12 xl:w-full @if ($activePage == 'search') {{$activeClass}} @endif">
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

        @auth
        <li class="lg:w-12 lg:h-12 xl:w-full @if ($activePage == 'notifications') {{$activeClass}} @endif">
            <div class="w-full h-full flex items-center justify-center">
                <a href="{{ $authenticated ? route('notifications') : route('login') }}" class=" lg:h-full lg:w-full lg:flex lg:items-center lg:justify-center 
                            xl:justify-start">
                    <div class="lg:w-8">
                        <i class="fa-solid fa-bell fa-xl"></i>
                    </div>
                    <p class="hidden xl:block ml-4">Notifications</p>
                </a>
            </div>
        </li>
        @endauth

        <li class="lg:w-12 lg:h-12 xl:w-full @if ($activePage == 'profile') {{$activeClass}} @endif">
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

        <li class="hidden lg:flex lg:w-12 lg:h-12 xl:w-full @if ($activePage == 'network') {{$activeClass}} @endif">
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

        <li class="hidden lg:flex lg:w-12 lg:h-12 xl:w-full @if ($activePage == 'settings') {{$activeClass}} @endif">
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

        @auth
        <li class=" w-9 h-9 flex items-center justify-center
                    lg:w-12 lg:h-12 lg:p-1 xl:w-full xl:p-0">
            <button class="add-post-on flex w-full h-full rounded-full dark:bg-dark-active items-center justify-center cursor-pointer
                        xl:justify-center xl:items-center">
                <span class="hidden ml-4 xl:block xl:m-0">New Post</span> {{-- This is hidden on mobile devices --}}
                <i class="fa-solid fa-plus fa-xl xl:hidden"></i> {{--This is hidden on desktop devices --}}
            </button>
        </li>
        @endauth

        <div class="hidden lg:flex lg:flex-col lg:flex-grow lg:items-center lg:justify-end pb-8">
            <li class="hidden lg:flex lg:w-12 lg:h-12 xl:w-full mb-12">
                <div class="flex items-center w-full justify-center">
                    <a href="{{ $authenticated ? route('logout') : route('login') }}"
                        class="lg:h-full lg:w-full lg:flex lg:items-center lg:justify-center xl:justify-start">
                        <div class="lg:w-8">
                            <i
                                class="fa-solid {{ $authenticated ? 'right-from-bracket fa-sign-out-alt' : 'fa-sign-in-alt' }} fa-xl"></i>
                        </div>
                        <p class="hidden xl:block ml-4">{{ $authenticated ? 'Logout' : 'Login' }}</p>
                    </a>
                </div>
            </li>

            <li class="hidden lg:flex lg:w-12 lg:h-12 xl:w-full @if ($activePage == 'about') {{$activeClass}} @endif">
                <div class="flex items-center w-full justify-center">
                    <a href="{{ route('about') }}"
                        class="lg:h-full lg:w-full lg:flex lg:items-center lg:justify-center xl:justify-start">
                        <div class="lg:w-8">
                            <i class="fa-regular fa-circle-question fa-xl"></i>
                        </div>
                        <p class="hidden xl:block ml-4">About</p>
                    </a>
                </div>
            </li>

            <li class="hidden lg:flex lg:w-12 lg:h-12 xl:w-full @if ($activePage == 'features') {{$activeClass}} @endif">
                <div class="lg:flex lg:items-center lg:w-full lg:justify-center">
                    <a href="{{ route('features') }}"
                        class="lg:h-full lg:w-full lg:flex lg:items-center lg:justify-center xl:justify-start">
                        <div class="lg:w-8">
                            <i class="fa-regular fa-star fa-xl"></i>
                        </div>
                        <p class="hidden xl:block ml-4">Features</p>
                    </a>
                </div>
            </li>
        </div>
    </ul>
</nav>

{{-- Mobile Sidebar --}}
<div id="mobile-sidebar" class="fixed top-[6rem] -left-[70vw] w-[70vw] h-screen dark:bg-dark-primary border-r-2 dark:border-dark-neutral 
                                overflow-y-auto scrollbar-hide
                                transition-all ease-linear duration-200 z-[1] lg:hidden">

    <ul class="w-full flex flex-col items-center justify-center py-12">

        <li class="block h-12 w-2/3 @if ($activePage == 'home') {{$activeClass}} @endif">
            <div class="flex w-full h-full items-center justify-center">
                <a href="{{ route('home') }}" class="h-full w-full flex items-center justify-start">
                    <div class="w-8">
                        <i class="fa-solid fa-house fa-xl"></i>
                    </div>
                    <p class="block ml-4">Home</p>
                </a>
            </div>
        </li>

        <li class="block h-12 w-2/3 @if ($activePage == 'search') {{$activeClass}} @endif">
            <div class="flex w-full h-full items-center justify-center">
                <a href="{{ route('search') }}" class="h-full w-full flex items-center justify-start">
                    <div class="w-8">
                        <i class="fa-solid fa-search fa-xl"></i>
                    </div>
                    <p class="block ml-4">Search</p>
                </a>
            </div>
        </li>

        @auth
        <li class="block h-12 w-2/3 @if ($activePage == 'notifications') {{$activeClass}} @endif">
            <div class="flex w-full h-full items-center justify-center">
                <a href="{{ $authenticated ? route('notifications') : route('login') }}"
                    class="h-full w-full flex items-center justify-start">
                    <div class="w-8">
                        <i class="fa-solid fa-bell fa-xl"></i>
                    </div>
                    <p class="block ml-4">Notifications</p>
                </a>
            </div>
        </li>
        @endauth

        <li class="block h-12 w-2/3 @if ($activePage == 'profile') {{$activeClass}} @endif">
            <div class="flex w-full h-full items-center justify-center">
                <a href="{{  $authenticated ? url('/profile/' . $username) : route('login') }}"
                    class="h-full w-full flex items-center justify-start">
                    <div class="w-8">
                        <i class="fa-solid fa-user fa-xl"></i>
                    </div>
                    <p class="block ml-4">Profile</p>
                </a>
            </div>
        </li>

        <li class="block h-12 w-2/3 @if ($activePage == 'network') {{$activeClass}} @endif">
            <div class="flex w-full h-full items-center justify-center">
                <a href="{{ $authenticated ? route('profile.network', ['username' => $username]) : route('login') }}"
                    class="h-full w-full flex items-center justify-start">
                    <div class="w-8">
                        <i class="fa-solid fa-globe fa-xl"></i>
                    </div>
                    <p class="block ml-4">Network</p>
                </a>
            </div>
        </li>

        <li class="block h-12 w-2/3 @if ($activePage == 'settings') {{$activeClass}} @endif">
            <div class="flex w-full h-full items-center justify-center">
                <a href="{{ $authenticated ? route('settings.show') : route('login') }}"
                    class="h-full w-full flex items-center justify-start">
                    <div class="w-8">
                        <i class="fa-solid fa-gear fa-xl"></i>
                    </div>
                    <p class="block ml-4">Settings</p>
                </a>
            </div>
        </li>

        <div class="flex flex-col w-full flex-grow items-center justify-end pb-8">
            <li class="block h-12 w-2/3 @if ($activePage == 'about') {{$activeClass}} @endif">
                <div class="flex w-full h-full items-center justify-center">
                    <a href="{{ route('about') }}" class="h-full w-full flex items-center justify-start">
                        <div class="w-8">
                            <i class="fa-regular fa-circle-question fa-xl"></i>
                        </div>
                        <p class="block ml-4">About</p>
                    </a>
                </div>
            </li>

            <li class="block h-12 w-2/3 @if ($activePage == 'features') {{$activeClass}} @endif">
                <div class="flex w-full h-full items-center justify-center">
                    <a href="{{ route('features') }}" class="h-full w-full flex items-center justify-start">
                        <div class="w-8">
                            <i class="fa-regular fa-star fa-xl"></i>
                        </div>
                        <p class="block ml-4">Features</p>
                    </a>
                </div>
            </li>

            <li class="block h-12 w-2/3">
                <div class="flex w-full h-full items-center justify-center">
                    <a href="{{ $authenticated ? route('logout') : route('login') }}"
                        class="h-full w-full flex items-center justify-start">
                        <div class="w-8">
                            <i
                                class="fa-solid {{ $authenticated ? 'right-from-bracket fa-sign-out-alt' : 'fa-sign-in-alt' }} fa-xl"></i>
                        </div>
                        <p class="block ml-4">{{ $authenticated ? 'Logout' : 'Login' }}</p>
                    </a>
                </div>
            </li>
        </div>
    </ul>
</div>