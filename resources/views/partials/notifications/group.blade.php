@php
$type = $notification->getGroupNotificationType();
$group = $notification->group;
$who = $notification->otherUser;
$profile_link = route('profile.show', ['username' => $who->username]);
$pfp = $who->getProfilePicture();
$group_link = route('group.show', ['id' => $group->id]);
$seen = $notification->seen;

Log::debug("type below:");
Log::debug($type);
Log::debug($group->toJson());
Log::debug($who->toJson());
@endphp

<div class="flex items-center w-full h-14 p-1 border-t dark:border-dark-neutral first:border-0"
    data-id="{{ $notification->id }}" data-type="{{ $type }}">
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
    @if ($type === 'Request')
    <div class="flex flex-col items-start justify-center h-12 ml-2 text-xs">
        <a href="{{ $profile_link }}" class="flex items-center dark:text-dark-active">
            <h2>{{ $who->username }}</h2>
        </a>
        <a href="{{ $group_link }}">
            <h2>wants to join {{ $group->name }}</h2>
        </a>
    </div>
    <div class="flex flex-grow items-center justify-end gap-2">
        <button id="ga{{ $who->id }}gid{{ $group->id }}" class="member-accept w-6 h-6 rounded-full dark:bg-dark-active"
            data-user="{{ $who->id }}" data-group="{{ $group->id }}">
            <i class="fa-solid fa-check"></i>
        </button>
        <button id="gr{{ $who->id }}gid{{ $group->id }}" class="member-reject w-6 h-6 rounded-full dark:bg-dark-neutral"
            data-user="{{ $who->id }}" data-group="{{ $group->id }}">
            <i class="fa-solid fa-times"></i>
        </button>
    </div>
    @elseif ($type === 'Invitation')
    <div class="flex flex-col items-start justify-center h-12 ml-2 text-xs">
        <a href="{{ $profile_link }}" class="flex items-center dark:text-dark-active">
            <h2>{{ $who->username }}</h2>
        </a>
        <a href="{{ $group_link }}">
            <h2>invited you to join {{ $group->name }}</h2>
        </a>
    </div>
    <div class="flex flex-grow items-center justify-end gap-2">
        <button id="ga{{ $who->id }}gid{{ $group->id }}" class="invitation-accept w-6 h-6 rounded-full dark:bg-dark-active"
            data-group-id="{{ $group->id }}">
            <i class="fa-solid fa-check"></i>
        </button>
        <button id="gr{{ $who->id }}gid{{ $group->id }}" class="invitation-reject w-6 h-6 rounded-full dark:bg-dark-neutral"
            data-group-id="{{ $group->id }}">
            <i class="fa-solid fa-times"></i>
        </button>
    </div>
    @endif
</div>