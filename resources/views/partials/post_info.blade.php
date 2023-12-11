@php
$editable = $showEdit && $post->isCreatedByCurrentUser();
@endphp
<!-- <div class="flex flex-col gap-4 m-1 post-info">
    <header class="flex items-center justify-start user-date space-x-2">
        <img class="w-8 h-8 rounded-full ring-1 ring-dark-neutral" src="{{ $post->createdBy->getProfilePicture() }}"
            alt="User photo">
        <a class="" href="/profile/{{ $post->createdBy->username }}">
            {{ $post->createdBy->username }}
        </a>
        <span class="date">{{ $post->created_at }}</span>
    </header>
    <div class='text-sm'>
        <a href="/post/{{ $post->id }}">
            <p>{{ $post->content }}</p> -->
<div class="flex flex-col gap-4 m-1 post-info">
    <header class="flex items-center justify-start user-date space-x-2">
        <img class="w-8 h-8 rounded-full ring-1 ring-dark-neutral" src="{{ $post->createdBy->getProfilePicture() }}"
            alt="User photo">
        <a class="" href="/profile/{{ $post->createdBy->username }}">
            {{ $post->createdBy->username }}
        </a>
        <!--<span class="date">{{ $post->created_at }}</span>-->
        @if ($editable)
        <div class="edit-delete-post">
            <a href="#" class="edit edit-post">&#9998;</a>
            <a href="{{ url('/home') }}" class="delete delete-post">&#10761;</a>
        </div>
        @endif
    </header>
    <div class='post-body text-sm'>
        @if ($editable)
        @include('partials.create_post_form', ['formClass' => 'edit-post-info hidden', 'textPlaceholder' => 'Edit post',
        'contentValue' => $post->content, 'buttonText' => 'Update Post'])
        @endif
        <a class="post-link" href="/post/{{ $post->id }}">
            <p class='post-content'>{{ $post->content }}</p>
        </a>
        @if ($post->media() != null)
        @include('partials.post_image', ['post' => $post, 'editable' => $editable])
        @endif
    </div>
    <!-- <div class="flex justify-between">
        <h3 class="flex">
            <button class="like-button" data-id="{{ $post->id }}" data-liked="{{ $post->liked ? 'true' : 'false' }}">
                at if($post->liked) -->
    {{-- @php
    $isLiked = $post->likedByUser();
    $color = $isLiked ? 'red' : 'black';
    @endphp --}}
    <div class="flex justify-between">
        <h3 class="flex">
            <button class="like-button mr-1" data-id="{{ $post->id }}"
                data-liked="{{ $post->liked ? 'true' : 'false' }}">
                <i class="far fa-heart dark:text-dark-neutral"></i>
            </button>
            <span class="ml-2">{{ count($post->likes) }}</span>
        </h3>

        <span>{{ $post->comments->count() }} comments</span>
    </div>
</div>