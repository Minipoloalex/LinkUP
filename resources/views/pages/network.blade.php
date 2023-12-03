@extends('layouts.app')

@section('title', 'Network')

@section('content')
    <main id="network-page" class="grid grid-cols-4 absolute top-32 left-0 w-screen px-64">
        @include('partials.side.navbar')
        <section class="col-span-2 flex flex-grow pt-16 overflow-y-auto scrollbar-hide" id="content">
            <section id="network" class="flex flex-col w-full gap-10">
                @php
                    $isMyProfile = Auth::check() && Auth::user()->id == $user->id;
                @endphp
                <header class="flex flex-row justify-around">
                    <button id="followers-button"
                        class="w-full p-2 border-2 active after:content-['_Followers']">{{ $user->followers->count() }}</button>
                    <button id="following-button"
                        class="w-full p-2 border-y-2 border-r-2 after:content-['_Following']">{{ $user->following->count() }}</button>
                    @if ($isMyProfile)
                        <button id="follow-requests-button"
                            class="w-full p-2 border-y-2 border-r-2 after:content-['_Requests']">{{ $user->followRequestsReceived->count() }}</button>
                    @endif
                </header>
                <div id="followers-list" class="flex flex-col gap-2">
                    @forelse ($user->followers as $follower)
                        @include('partials.network.follower_card', [
                            'user' => $follower,
                            'isMyProfile' => $isMyProfile,
                        ])
                    @empty
                        @if ($isMyProfile)
                            <p class="empty-list">You have no followers</p>        
                        @else
                            <p class="empty-list">{{$user->username}} has no followers</p>
                        @endif
                    @endforelse
                </div>
                <div id="following-list" class="flex flex-col gap-2 hidden">
                    @forelse ($user->following as $following)
                        @include('partials.network.following_card', [
                            'user' => $following,
                            'isMyProfile' => $isMyProfile,
                        ])
                    @empty
                        @if ($isMyProfile)
                            <p class="empty-list">You are not following anyone</p>
                        @else
                            <p class="empty-list">{{ $user->username }} is not following anyone</p>
                        @endif
                    @endforelse
                </div>
                @if ($isMyProfile)
                    <div id="follow-requests-list" class="flex flex-col gap-2 hidden">
                        @php
                            $followRequestsReceived = $user->followRequestsReceived;
                        @endphp
                        @forelse ($followRequestsReceived as $followRequest)
                            @include('partials.network.follow_request_card', [
                                'user' => $followRequest->userRequesting
                            ])
                        @empty
                            <p class="empty-list">You have received no follow requests</p>
                        @endforelse
                    </div>
                @endif
            </section>
        </section>
        @include('partials.side.notifications-tab')
    </main>
@endsection
