@php
$editable = $showEdit && $post->isCreatedByCurrentUser();
@endphp
<div class="post-info">
    <header>
        <div class="user-date">
            <img class="user-image rounded-full" src="{{ $post->createdBy->getProfilePicture() }}" alt="User photo">
            <a class="post-info-user" href="/profile/{{ $post->createdBy->username }}">{{ $post->createdBy->username }}</a>
            <span class="date">{{ $post->created_at }}</span>
        </div>
    </header>
    <div class='post-body'>
        <a class="post-link" href="/post/{{ $post->id }}">
            <p class='post-content'>{{ $post->content }}</p>
        </a>
        @if ($post->media() != null)
            @include('partials.post_image', ['post' => $post, 'editable' => $editable])
        @endif
    </div>
    <div class="post-footer">
        <h3 class="post-likes">
            <button class="like-button mr-1" data-id="{{ $post->id }}"
                data-liked="{{ $post->liked ? 'true' : 'false' }}">
                @if($post->liked)
                &#128148;
                @else
                &#10084;
                @endif
            </button>

            <span class="likes">{{ count($post->likes) }}</span>
        </h3>

        <span class="nr-comments">{{ $post->comments->count() }}</span>
    </div>
</div>