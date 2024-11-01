@php
$editable = $showEdit && $post->isCreatedByCurrentUser();
$postLink = $hasAdminLink ? route('admin.post', $post->id) : route('post', $post->id);
$userLink = $hasAdminLink ? route('admin.user', $post->createdBy->username)
: route('profile.show', $post->createdBy->username);
$icon = $post->is_private ? 'fa-lock' : 'fa-unlock';
@endphp
<div class="flex flex-col gap-4 m-1 post-info">
    <header class="flex items-center justify-start space-x-2">
        <a href="{{ $userLink }}">
            <img class="w-8 h-8 rounded-full ring-1 ring-dark-neutral" src="{{ $post->createdBy->getProfilePicture() }}?v={{ time() }}"
                alt="User photo">
        </a>
        <div class="flex flex-col">
            <div class="flex items-center justify-start">
                <a class="before:content-['@']" href="{{ $userLink }}">{{ $post->createdBy->username }}</a>
                @if ($post->is_private)
                <div class="ml-2 flex h-full items-center justify-center text-xs">
                    <i class="fas fa-lock fa-xs"></i>
                </div>
                @endif
                @if ($post->group)
                @php
                $group = $post->group;
                $groupLink = $hasAdminLink ? route('admin.group', $group->id) : route('group.show', $group->id);
                @endphp
                <a href="{{ $groupLink }}" class="grow text-sm ml-1 text-dark-active">to {{ $group->name }}</a>
                @endif  
            </div>
            <span class="text-xs text-gray-300">{{ date('H:i · d M Y', strtotime($post->created_at)) }}</span>
        </div>
        @if ($editable || $showGroupOwnerDelete)
        <div class="edit-delete-post flex items-center justify-end flex-grow">
            @if ($editable)
            <button class="edit-post"><i class="p-2 fas fa-edit"></i></button>
            @if ($post->id_group === null)
            <button class="privacy-post-button" data-post-id="{{ $post->id }}"><i
                    class="p-2 fas {{ $icon }}"></i></button>
            @endif
            @endif
            <button class="delete-post"><i class="p-2 fas fa-trash-alt"></i></button>
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
    $authenticated = Auth::check();
    @endphp
    <div class="flex justify-between">
        <h3 class="flex">
            <button class="{{ $authenticated ? 'like-button' : '' }} mr-1" data-id="{{ $post->id }}"
                data-liked="{{ $isLiked ? 'true' : 'false' }}">
                <i class="{{ $class }}"></i>
            </button>
            <span class="ml-2">{{ count($post->likes) }}</span>
        </h3>

        <div>
            <span class="nr-comments after:content-['_comments']">{{ $post->comments->count() }}</span>
        </div>
    </div>
</div>