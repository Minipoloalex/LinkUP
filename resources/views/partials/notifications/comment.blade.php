@php
$comment = $notification->comment;
$whoCommented = $notification->whoCommented();
$pfp = $whoCommented->getProfilePicture();
$profile_link = route('profile.show', ['username' => $whoCommented->username]);
$comment_link = route('post', ['id' => $comment->id]);
$parent_post = $comment->parent;
$home ??= false;
$seen = $notification->seen;
@endphp

@if ($home)

<!-- Notification container for right tab in home page -->
<div class="flex items-center w-full h-14 p-1 border-t dark:border-dark-neutral first:border-0">
    <div class="h-12 w-1 flex items-center justify-center">
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
        <a href="{{ $profile_link }}" class="flex items-center dark:text-dark-active">
            <h2>{{ $whoCommented->username }}</h2>
        </a>
        <a href="{{ $comment_link }}">
            <h2>commented on your post: {{ $comment->content }}</h2>
        </a>
    </div>
</div>

@else

<!-- Notification container for notifications page -->
<div class="h-full flex items-center w-full">
    <div class="h-24 w-24 flex items-center justify-center">
        <a href="{{ $profile_link }}">
            <img src="{{ $pfp }}" alt="avatar" class="w-12 h-12 rounded-full">
        </a>
    </div>
    <div class="flex flex-col items-start justify-center w-5/6">
        <a href="{{ $profile_link }}" class="text-slate-400 font-bold flex items-center">
            <h2 class="ml-4">{{ $whoCommented->username }}</h2>
        </a>
        <a href="{{ $comment_link }}" class="ml-4 text-sm font-bold">
            <h2>commented on your post: {{ $comment->content }}</h2>
        </a>
    </div>
</div>

@endif