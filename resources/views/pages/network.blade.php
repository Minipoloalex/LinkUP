@extends('layouts.app')

@section('title', 'Network')

@section('content')
<main id="network-page" class=" relative flex flex-col w-screen overflow-clip overflow-y-scroll h-[calc(100vh-10rem)]
                                lg:w-full lg:h-[calc(100vh-6rem)]">
    <section class="flex overflow-clip overflow-y-auto scrollbar-hide" id="content">
        <section id="network" class="flex flex-col flex-grow w-full h-min">
            @php
            $isMyProfile = Auth::check() && Auth::user()->id == $user->id;
            @endphp
            <header class="flex flex-row justify-around sticky top-0 left-0 dark:bg-dark-primary">
                <button id="followers-button" class="w-full p-2 border-2 active">{{
                    $user->followers->count() }} Followers</button>
                <button id="following-button" class="w-full p-2 border-y-2 border-r-2">{{
                    $user->following->count() }} Following</button>
                @if ($isMyProfile)
                <button id="follow-requests-button" class="w-full p-2 border-y-2 border-r-2">{{
                    $user->followRequestsReceived->count() }} Requests</button>
                @endif
                <button id="groups-button" class="w-full p-2 border-y-2">{{
                    $user->groups->count() }} Groups</button>
            </header>
            <div id="followers-list" class="flex flex-col">
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
            <div id="following-list" class="flex flex-col hidden">
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
            <div id="follow-requests-list" class="flex flex-col hidden">
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
            <div id="groups-list" class="flex flex-col hidden">
                @forelse ($user->groups as $groupMember)
                @include('partials.network.group_card', [
                'group' => $groupMember->group,
                // 'user' => $user,
                ])
                @empty
                <p class="empty-list">You are not a member of any group</p>
                @endforelse
            </div>
        </section>
    </section>
</main>
@endsection