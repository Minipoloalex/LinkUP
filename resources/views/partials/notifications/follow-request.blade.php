@php
$user = $notification->userRequesting()->first();
$profile_link = route('profile.show', ['username' => $user->username]);
$pfp = $user->getProfilePicture();
@endphp

<div class="flex items-center w-full h-14 p-1 border-t dark:border-dark-neutral first:border-0"
    data-id="{{ $notification->id }}">
    <div class="h-12 w-1 flex items-center justify-center">
        <div class="h-1 w-1 rounded-full dark:bg-dark-active unseen"></div>
    </div>
    <div class="h-12 min-w-[2rem] flex items-center justify-center ml-2">
        <a href="{{ $profile_link }}">
            <img src="{{ $pfp }}" alt="avatar" class="w-8 h-8 rounded-full">
        </a>
    </div>
    <div class="flex flex-col items-start justify-center h-12 ml-2 text-xs">
        <a href="{{ $profile_link }}" class="flex items-center dark:text-dark-active">
            <h2>{{ $user->username }}</h2>
        </a>
        <h2>wants to follow you.</h2>
    </div>
    <div class="flex flex-grow items-center justify-end">
        @include('partials.components.button', ['id' => 'fa' . $user->id, 'icon' => 'fa-check', 'color' => 'green',
        'text' => null, 'classes' => 'follow-accept w-12 mr-4', 'data' => ['user' => $user->id]])
        @include('partials.components.button', ['id' => 'fr' . $user->id, 'icon' => 'fa-times', 'color' => 'red',
        'text' => null, 'classes' => 'follow-reject w-12', 'data' => ['user' => $user->id]])
    </div>
</div>