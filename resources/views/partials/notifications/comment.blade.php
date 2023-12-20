@php
$comment = $notification->comment;
$whoCommented = $notification->whoCommented();
$pfp = $whoCommented->getProfilePicture();
$profile_link = route('profile.show', ['username' => $whoCommented->username]);
$comment_link = route('post', ['id' => $comment->id]);
$parent_post = $comment->parent;
$seen = $notification->seen;
@endphp

<div class="flex items-center w-full h-14 p-1 border-t dark:border-dark-neutral first:border-0"
    data-id="{{ $notification->id }}">
    <div class="h-12 w-1 flex items-center justify-center">
        @if(!$seen)
        <div class="h-1 w-1 rounded-full dark:bg-dark-active unseen"></div>
        @endif
    </div>
    <div class="h-12 min-w-[2rem] flex items-center justify-center ml-2">
        <a href="{{ $profile_link }}">
            <img src="{{ $pfp }}" alt="avatar" class="w-8 h-8 rounded-full">
        </a>
    </div>
    <div class="flex flex-col items-start justify-center h-12 ml-2 text-xs">
        <a href="{{ $profile_link }}" class="flex items-center dark:text-dark-active">
            <h2>{{ $whoCommented->username }} {{ $seen ? 'SEEN' : 'NOT SEEN' }}</h2>
        </a>
        <a href="{{ $comment_link }}">
            <h2>commented on your post: {{ $comment->content }}</h2>
        </a>
    </div>
</div>