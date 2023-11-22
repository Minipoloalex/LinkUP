@extends('layouts.app')

@section('title', 'profile-page')

<main id="homepage" class="grid grid-cols-4 absolute top-32 left-0 w-screen px-64">
    <div id="dark-overlay" class="hidden fixed top-0 left-0 w-full h-full bg-black" style="opacity: 0.8;"></div>

    @include('partials.side.navbar')
    <section class="col-span-2 flex flex-grow pt-16 overflow-y-auto scrollbar-hide " id="content">

        <section class="user-banner flex-grow h-full">
            @include('partials.profile.user-banner')
            @include('partials.profile.post-profile')
        </section>
    </section>
    @include('partials.side.right-tab-profile')
</main>

