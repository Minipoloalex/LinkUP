@extends('layouts.app')
@section('title', 'Profile')

@section('content')
<main id="homepage" class=" flex flex-col w-screen overflow-clip overflow-y-scroll h-screen
                            md:pl-16
                            lg:px-56">
    <section class="flex flex-grow overflow-y-auto scrollbar-hide" id="content">
        <div id="dark-overlay" class="hidden fixed top-0 left-0 w-full h-full bg-black" style="opacity: 0.8;"></div>
        <section class="flex-grow h-full">
            @include('partials.profile.user-banner')
            @include('partials.profile.post-profile')
            <div id="fetcher" class="h-16"></div>
        </section>
    </section>
</main>
@endsection