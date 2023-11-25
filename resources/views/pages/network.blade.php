@extends('layouts.app')

@section('title', 'Network')

@section('content')
<main id="network-page" class="grid grid-cols-4 absolute top-32 left-0 w-screen px-64">
    @include('partials.side.navbar')
    <section class="col-span-2 flex flex-grow pt-16 overflow-y-auto scrollbar-hide" id="content">
        <section id="network" class="flex flex-col w-full gap-10">
            <header class="flex flex-row justify-around">
                <button id="followers-button" class="w-full p-2 border-2 active after:content-['_Followers']">{{ $user->followers->count() }}</button>
                <button id="following-button" class="w-full p-2 border-y-2 border-r-2 after:content-['_Following']">{{ $user->following->count() }}</button>
            </header>
            @php
                $editable = Auth::check() && Auth::user()->id == $user->id;
            @endphp
            <div id="followers-list" class="flex flex-col gap-2">                
                @foreach ($user->followers as $follower)
                    @include('partials.user_follow', ['user' => $follower, 'type' => 'follower', 'editable' => $editable])
                @endforeach
            </div>
            <div id="following-list" class="flex flex-col gap-2 hidden">
                @foreach ($user->following as $following)
                    @include('partials.user_follow', ['user' => $following, 'type' => 'following', 'editable' => $editable])
                @endforeach
            </div>
        </section>
    </section>
    @include('partials.side.notifications-tab')
</main>
@endsection
