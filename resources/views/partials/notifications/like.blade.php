@php
$post = $notification->post;
$liked_by = $notification->likedByUser;
$profile_link = route('profile.show', ['username' => $liked_by->username]);
$pfp = $liked_by->getProfilePicture();
$post_link = route('post', ['id' => $post->id]);
if (strlen($post->content) > 30) $post->content = substr($post->content, 0, 30) . '...';
$home ??= false;
@endphp

@if ($home)

<!-- Notification container for right tab in home page -->
<div class="flex items-center w-full h-14 p-1 border-t dark:border-dark-neutral first:border-0">
    <div class="h-12 min-w-[2rem] flex items-center justify-center">
        <a href="{{ $profile_link }}">
            <img src="{{ $pfp }}" alt="avatar" class="w-8 h-8 rounded-full">
        </a>
    </div>
    <div class="flex flex-col items-start justify-center h-12 ml-2 text-xs">
        <a href="{{ $profile_link }}" class="font-bold flex items-center dark:text-dark-active">
            <h2>{{ $liked_by->username }}</h2>
        </a>
        <a href="{{ $post_link }}" class="font-bold">
            <h2>liked your post: {{ $post->content }}</h2>
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
            <h2 class="ml-4">{{ $liked_by->username }}</h2>
        </a>
        <a href="{{ $post_link }}" class="ml-4 text-sm font-bold">
            <h2>liked your post: {{ $post->content }}</h2>
        </a>
    </div>
</div>

@endif