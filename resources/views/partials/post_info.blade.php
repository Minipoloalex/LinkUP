@php
$editable = $showEdit && $post->isCreatedByCurrentUser();
$postLink = $hasAdminLink ? route('admin.post', $post->id) : route('post', $post->id);
@endphp
<div class="post-info">
    <header>
        <div class="user-date">
            <a href="{{ route('profile.show', $post->createdBy->username )}}">
                <img class="user-image rounded-full" src="{{ $post->createdBy->getProfilePicture() }}" alt="User photo">
            </a>
            <a class="post-info-user" href="{{ route('profile.show', $post->createdBy->username )}}">{{ $post->createdBy->username }}</a>
            <span class="date">{{ $post->created_at }}</span>
        </div>
        @if ($editable)
        <div class="edit-delete-post">
            <a href="#" class="text-2xl edit edit-post"><i class="p-2 fas fa-edit"></i></a>
            <a href="{{ url('/home') }}" class="text-2xl delete delete-post"><i class="p-2 fas fa-trash-alt"></i></a>
        </div>
        @endif
        @if ($hasAdminDelete)
        <div class="admin-delete-post">
            <div class="delete delete-post">
                <button class="text-2xl"><i class="p-2 fas fa-trash-alt"></i></button>
            </div>
        </div>
        @endif
    </header>
    <div class='post-body'>
        @if ($editable)
        @include('partials.create_post_form', ['formClass' => 'edit-post-info hidden', 'textPlaceholder' => 'Edit post',
        'contentValue' => $post->content, 'buttonText' => 'Update Post'])
        @endif
        {{-- <a class="post-link" href="/post/{{ $post->id }}"> --}}
        <a class="post-link" href="{{ $postLink }}">
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