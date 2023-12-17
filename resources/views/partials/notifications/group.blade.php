@php
$type = $notification->type;
$group = $notification->group;
$who = $notification->otherUser()->first();
$profile_link = route('profile.show', ['username' => $who->username]);
$pfp = $who->getProfilePicture();
$group_link = route('group.show', ['id' => $group->id]);
@endphp

<div class="h-full flex items-center">
    <div class="h-24 w-1/6 flex items-center justify-center">
        <a href="{{ $profile_link }}">
            <img src="{{ $pfp }}" alt="avatar" class="w-12 h-12 rounded-full">
        </a>
    </div>
    <div class="flex flex-col items-start justify-center w-2/3">
        <a href="{{ $profile_link }}" class="text-slate-400 font-bold flex items-center">
            <h2 class="ml-4">{{ $who->username }}</h2>
        </a>
        <a href="{{ $group_link }}" class="ml-4 text-sm font-bold">
            <h2>wants to join {{ $group->name }}</h2>
        </a>
    </div>
    <div class="flex items-end justify-center w-1/6">
        @include('partials.components.button', ['id' => 'ga' . $who->id . 'gid' . $group->id, 'icon' => 'fa-check',
        'color' => 'green',
        'text' => null, 'classes' => 'member-accept w-12 mr-4', 'data' => ['group' => $group->id, 'user' => $who->id]])
        @include('partials.components.button', ['id' => 'gr' . $who->id . 'gid' . $group->id, 'icon' => 'fa-times',
        'color' => 'red',
        'text' => null, 'classes' => 'member-reject w-12', 'data' => ['group' => $group->id, 'user' => $who->id]])
    </div>
</div>