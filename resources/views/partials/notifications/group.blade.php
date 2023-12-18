@php
$type = $notification->type;
$group = $notification->group;
$who = $notification->otherUser()->first();
$profile_link = route('profile.show', ['username' => $who->username]);
$pfp = $who->getProfilePicture();
$group_link = route('group', ['id' => $group->id]);
$seen = $notification->seen;
@endphp

<div class="flex items-center w-full h-14 p-1 border-t dark:border-dark-neutral first:border-0"
    data-id="{{ $notification->id }}">
    <div class="h-12 w-1 flex items-center justify-center unseen">
        @if(!$seen)
        <div class="h-1 w-1 rounded-full dark:bg-dark-active"></div>
        @endif
    </div>
    <div class="h-12 min-w-[2rem] flex items-center justify-center ml-2">
        <a href="{{ $profile_link }}">
            <img src="{{ $pfp }}" alt="avatar" class="w-8 h-8 rounded-full">
        </a>
    </div>
    <div class="flex flex-col items-start justify-center h-12 ml-2 text-xs">
        <a href="{{ $profile_link }}" class="font-bold flex items-center dark:text-dark-active">
            <h2>{{ $who->username }}</h2>
        </a>
        <a href="{{ $group_link }}" class="font-bold">
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