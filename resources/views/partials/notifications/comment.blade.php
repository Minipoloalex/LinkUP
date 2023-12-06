@php
$comment = $notification->comment;
$whoCommented = $notification->whoCommented();
$pfp = $whoCommented->getProfilePicture();
$profile_link = route('profile.show', ['username' => $whoCommented->username]);
$comment_link = route('post.page', ['id' => $comment->id]);
$parent_post = $comment->parent;
@endphp

<div class="h-24 flex items-center w-full">
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