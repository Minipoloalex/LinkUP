@php
$editable = $showEdit && $post->isCreatedByCurrentUser();
$postLink = $hasAdminLink ? route('admin.post', $post->id) : route('post', $post->id);
@endphp
<div class="flex flex-col gap-4 m-1 post-info">
    <header class="flex items-center justify-start space-x-2">
        <a href="/profile/{{ $post->createdBy->username }}">
            <img class="w-8 h-8 rounded-full ring-1 ring-dark-neutral" src="{{ $post->createdBy->getProfilePicture() }}"
                alt="User photo">
        </a>
        <a class="" href="/profile/{{ $post->createdBy->username }}">
            {{ $post->createdBy->username }}
        </a>
        {{-- <span class="date">{{ $post->created_at }}</span> --}}
        @if ($editable)
        <div class="edit-delete-post">
            <button class="text-2xl edit-post"><i class="p-2 fas fa-edit"></i></button>
            <button class="text-2xl delete-post"><i class="p-2 fas fa-trash-alt"></i></button>
        </div>
        @endif
        @if ($hasAdminDelete)
        <div class="admin-delete-post">
            <button class="text-2xl delete-post"><i class="p-2 fas fa-trash-alt"></i></button>
        </div>
        @endif
    </header>
    <div class='post-body text-sm'>
        @if ($editable)
        @include('partials.create_post_form', ['formClass' => 'edit-post-info hidden', 'textPlaceholder' => 'Edit post',
        'contentValue' => $post->content, 'buttonText' => 'Update Post'])
        @endif
            <a class="post-link" href="{{ $postLink }}">
                <p class='post-content'>{{ $post->content }}</p>
            </a>
            @if ($post->media() != null)
            @include('partials.post_image', ['post' => $post, 'editable' => $editable, 'linkTo' => $postLink])
            @endif
    </div>
    @php
    $isLiked = $post->likedByUser();
    $class = $isLiked ? 'fas fa-heart liked' : 'far fa-heart unliked';
    @endphp
    <div class="flex justify-between">
        <h3 class="flex">
            <button class="like-button mr-1" data-id="{{ $post->id }}" data-liked="{{ $isLiked ? 'true' : 'false' }}">
                <i class="{{ $class }}"></i>
            </button>
            <span class="ml-2">{{ count($post->likes) }}</span>
        </h3>

        <div>
            <span class="nr-comments mr-1">{{ $post->comments->count() }}</span><span>comments</span>
        </div>
    </div>

</div>