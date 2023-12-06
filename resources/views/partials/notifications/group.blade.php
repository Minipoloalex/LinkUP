@php
$type = $notification->type;
$group = $notification->group;
$who = $notification->otherUser()->first();
$profile_link = route('profile.show', ['username' => $who->username]);
$pfp = $who->getProfilePicture();
$group_link = route('group', ['id' => $group->id]);
@endphp

<div class="h-24 flex items-center">
    <div class="h-24 w-24 flex items-center justify-center">
        <a href="{{ $profile_link }}">
            <img src="{{ $pfp }}" alt="avatar" class="w-12 h-12 rounded-full">
        </a>
    </div>
    <div class="flex flex-col items-start justify-center">
        <a href="{{ $profile_link }}" class="text-slate-400 font-bold flex items-center">
            <h2 class="ml-4">{{ $who->username }}</h2>
        </a>
        <a href="{{ $group_link }}" class="ml-4 text-sm font-bold">
            <h2>wants to join {{ $group->name }}</h2>
        </a>
    </div>
</div>