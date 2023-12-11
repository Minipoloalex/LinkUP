@php
$userCanSeePosts = $user->is_private === false || (Auth::check() && ($user->id === Auth::user()->id ||
Auth::user()->isFollowing($user)));
@endphp

@extends('layouts.app')
@section('title', 'Profile')

@section('content')
<main id="profile-page" class="flex flex-col w-screen h-screen">
    <section class="flex flex-grow" id="content">
        <div id="dark-overlay" class="hidden fixed top-0 left-0 w-full h-full bg-black" style="opacity: 0.8;"></div>
        <section id="posts-container" data-id="{{ $user->id }}" data-page="0"
            class=" overflow-clip overflow-y-scroll flex-grow h-full">
            @include('partials.profile.user-banner')
            @if ($userCanSeePosts)
            <div id="fetcher" class="h-16"></div>
            @else
            <p class="text-center">This user has a private profile.</p>
            @endif
        </section>
    </section>
    </section>
</main>
@endsection