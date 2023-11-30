@extends('layouts.app')

@section('title', 'Network')

@section('content')
    <main id="network-page" class="grid grid-cols-4 absolute top-32 left-0 w-screen px-64">
        @include('partials.side.navbar')
        <section class="col-span-2 flex flex-grow pt-16 overflow-y-auto scrollbar-hide" id="content">
            <section id="network" class="flex flex-col w-full gap-10">
                @php
                    $editable = Auth::check() && Auth::user()->id == $user->id;
                @endphp
                <header class="flex flex-row justify-around">
                    <button id="followers-button"
                        class="w-full p-2 border-2 active after:content-['_Followers']">{{ $user->followers->count() }}</button>
                    <button id="following-button"
                        class="w-full p-2 border-y-2 border-r-2 after:content-['_Following']">{{ $user->following->count() }}</button>
                    @if ($editable)
                        <button id="follow-requests-button"
                            class="w-full p-2 border-y-2 border-r-2 after:content-['_Requests']">{{ $user->followRequestsReceived->count() + $user->followRequestsSent->count() }}</button>
                    @endif
                </header>
                <div id="followers-list" class="flex flex-col gap-2">
                    @forelse ($user->followers as $follower)
                        @include('partials.network.follower_card', [
                            'user' => $follower,
                            'editable' => $editable,
                        ])
                    @empty
                        <p class="p-2">You have no followers</p>
                    @endforelse
                </div>
                <div id="following-list" class="flex flex-col gap-2 hidden">
                    @forelse ($user->following as $following)
                        @include('partials.network.following_card', [
                            'user' => $following,
                            'editable' => $editable,
                        ])
                    @empty
                        <p class="p-2">You are not following anyone</p>
                    @endforelse
                </div>
                @if ($editable)
                    <div id="follow-requests-list" class="flex flex-col gap-2 hidden">
                        @php
                            $followRequestsReceived = $user->followRequestsReceived;
                        @endphp
                        @forelse ($followRequestsReceived as $followRequest)
                            @php
                                Log::debug($followRequest->toJson());
                            @endphp
                            @include('partials.network.follow_request_card', [
                                'user' => $followRequest->userRequesting
                            ])
                        @empty
                            <p class="p-2">No requests received</p>
                        @endforelse
                    </div>
                @endif
                {{-- <section id="requests-sent">
                    <header class="border-2 w-full p-2">
                        <h2>Follow requests sent</h2>
                    </header>
                    @php
                        $followRequestsSent = $user->followRequestsSent;
                    @endphp
                    @forelse ($followRequestsSent as $followRequest)
                        @include('partials.network.user_follow_list', [
                            'user' => $followRequest->userNotified,
                            'editable' => $editable,
                            'buttons' => [['class' => 'cancel-follow-request', 'text' => 'Cancel']],
                        ])
                    @empty
                        <p class="p-2">No follow requests sent.</p>
                    @endforelse
                </section> --}}
            </section>
        </section>
        @include('partials.side.notifications-tab')
    </main>
@endsection
