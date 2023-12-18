@php
$user = $notification->userRequesting()->first();
$profile_link = route('profile.show', ['username' => $user->username]);
$pfp = $user->getProfilePicture();
$seen = $notification->seen;
@endphp

<div class="h-full flex items-center w-full" data-id="{{ $notification->id }}">
    <div class="h-12 w-1 flex items-center justify-center">
        @if(!$seen)
        <div class="h-1 w-1 rounded-full dark:bg-dark-active unseen"></div>
        @endif
    </div>
    <div class="h-24 w-1/6 flex items-center justify-center ml-2">
        <a href="{{ $profile_link }}">
            <img src="{{ $pfp }}" alt="avatar" class="w-12 h-12 rounded-full">
        </a>
    </div>
    <div class="flex flex-col items-start justify-center w-2/3">
        <a href="{{ $profile_link }}" class="text-slate-400 flex items-center">
            <h2 class="ml-4">{{ $user->username }}</h2>
        </a>
        <h2 class="ml-4 text-sm ">wants to follow you.</h2>
    </div>
    <div class="flex items-end justify-center w-1/6">
        @include('partials.components.button', ['id' => 'fa' . $user->id, 'icon' => 'fa-check', 'color' => 'green',
        'text' => null, 'classes' => 'follow-accept w-12 mr-4', 'data' => ['user' => $user->id]])
        @include('partials.components.button', ['id' => 'fr' . $user->id, 'icon' => 'fa-times', 'color' => 'red',
        'text' => null, 'classes' => 'follow-reject w-12', 'data' => ['user' => $user->id]])
    </div>
</div>