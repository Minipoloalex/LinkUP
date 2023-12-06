@php
$post = $notification->post;
$liked_by = $notification->likedByUser;
$profile_link = route('profile.show', ['username' => $liked_by->username]);
$pfp = $liked_by->getProfilePicture();
$post_link = route('post.page', ['id' => $post->id]);
@endphp

<div class="h-24 flex items-center w-full">
    <div class="h-24 w-24 flex items-center justify-center">
        <a href="{{ $profile_link }}">
            <img src="{{ $pfp }}" alt="avatar" class="w-12 h-12 rounded-full">
        </a>
    </div>
    <div class="flex flex-col items-start justify-center w-5/6">
        <a href="{{ $profile_link }}" class="text-slate-400 font-bold flex items-center">
            <h2 class="ml-4">{{ $liked_by->username }}</h2>
        </a>
        <a href="{{ $post_link }}" class="ml-4 text-sm font-bold">
            <h2>liked your post: {{ $post->content }}</h2>
        </a>
    </div>
</div>