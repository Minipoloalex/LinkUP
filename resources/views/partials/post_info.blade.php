@php
$editable = $showEdit && $post->isCreatedByCurrentUser();
@endphp
<div class="flex flex-col gap-4 m-1 post-info">
    <header class="flex items-center justify-start user-date space-x-2">
        <img class="w-8 h-8 rounded-full ring-1 ring-dark-neutral" src="{{ $post->createdBy->getProfilePicture() }}"
            alt="User photo">
        <a class="" href="/profile/{{ $post->createdBy->username }}">
            {{ $post->createdBy->username }}
        </a>
        <!--<span class="date">{{ $post->created_at }}</span>-->
    </header>
    <div class='text-sm'>
        <a href="/post/{{ $post->id }}">
            <p>{{ $post->content }}</p>
        </a>
        @if ($post->media() != null)
        @include('partials.post_image', ['post' => $post, 'editable' => $editable])
        @endif
    </div>
    <div class="flex justify-between">
        <h3 class="flex">
            <button class="like-button" data-id="{{ $post->id }}" data-liked="{{ $post->liked ? 'true' : 'false' }}">
                @if($post->liked)
                &#128148;
                @else
                &#10084;
                @endif
            </button>
            <span class="ml-2">{{ count($post->likes) }}</span>
        </h3>

        <span class="nr-comments after:content-['_comments']">{{ $post->comments->count() }}</span>
    </div>
</div>