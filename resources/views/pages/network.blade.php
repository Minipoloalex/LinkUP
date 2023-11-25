@extends('layouts.app')

@section('title', 'Network')

@section('content')
<main id="network-page" class="grid grid-cols-4 absolute top-32 left-0 w-screen px-64">
    @include('partials.side.navbar')
    <section class="col-span-2 flex flex-grow pt-16 overflow-y-auto scrollbar-hide" id="content">
        <section id="network" class="flex flex-col w-full gap-10">
            <header class="flex flex-row justify-around">
                <button id="followers-button" class="border-2 w-full p-2">{{ $user->followers->count() }} Followers</button>
                <button id="following-button" class="border-y-2 border-r-2 w-full p-2">{{ $user->following->count() }} Following</button>
            </header>
            <div id="followers-list" class="flex flex-col gap-2">
                @each('partials.user_follow', $user->followers, 'user')
            </div>
            <div id="following-list" class="flex flex-col gap-2 hidden">
                @each('partials.user_follow', $user->following, 'user')
            </div>
        </section>
    </section>
    @include('partials.side.notifications-tab')
</main>
@endsection
