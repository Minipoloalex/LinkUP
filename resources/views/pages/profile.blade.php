@php
$userCanSeePosts = $user->is_private === false || (Auth::check() && ($user->id === Auth::user()->id || Auth::user()->isFollowing($user)));
@endphp

@extends('layouts.app')

@section('title', 'profile-page')

@section('content')
    <main id="profile-page" class="grid grid-cols-4 absolute top-32 left-0 w-screen px-64">
        @include('partials.side.navbar')
        <section class="col-span-2 flex flex-grow pt-16 overflow-y-auto scrollbar-hide" id="content">
        <div id="dark-overlay" class="hidden fixed top-0 left-0 w-full h-full bg-black" style="opacity: 0.8;"></div>
            <section id="posts-container" data-id="{{ $user->id }}" data-page="0" class="user-banner flex-grow h-full">
                @include('partials.profile.user-banner')
                @if ($userCanSeePosts)
                    <div id="fetcher"></div>
                @else
                    <p class="text-center">This user has a private profile.</p>
                @endif
            </section>
        </section>
        @include('partials.side.right-tab-profile')
    </main>
@endsection
