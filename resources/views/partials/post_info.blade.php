@php
$editable = $showEdit && $post->isCreatedByCurrentUser();
@endphp
<div class="post-info">
    <header>
        <div class="user-date">
            <img class="user-image" src="{{ $post->createdBy->getProfilePicture() }}" alt="User photo">
            <a class="post-info-user" href="/profile/{{ $post->createdBy->username }}">{{ $post->createdBy->username
                }}</a>
            <span class="date">{{ $post->created_at }}</span>
        </div>
        @if ($editable)
        <div class="edit-delete-post">
            <a href="#" class="edit edit-post">&#9998;</a>
            <a href="{{ url('home') }}" class="delete delete-post">&#10761;</a>
        </div>
        @endif
    </header>
    <div class='post-body'>
        @if ($editable)
        @include('partials.create_post_form', ['formClass' => 'edit-post-info hidden', 'textPlaceholder' => 'Edit post',
        'contentValue' => $post->content, 'buttonText' => 'Update Post'])
        @endif
        <a class="post-link" href="/post/{{ $post->id }}">
            <p class='post-content'>{{ $post->content }}</p>
            @if ($post->media() != null)
            @include('partials.post_image', ['post' => $post, 'editable' => $editable])
            @endif
        </a>
    </div>
    <div class="post-footer">
        <h3 class="post-likes">
            <a href="#" class="like">&#10084;</a>
            <span class="likes">{{ $post->likes->count() }}</span>
        </h3>
        <span class="nr-comments">{{ $post->comments->count() }}</span>
    </div>
</div>