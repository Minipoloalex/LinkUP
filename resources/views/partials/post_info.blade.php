@php
    $editable = $post->isCreatedByCurrentUser();
@endphp
<div class="post-info m-1 flex flex-col gap-4">
    <header class="flex flex-row justify-between">
        <div class="flex flex-row">
            {{-- <img src="/users/{{ $post->id_created_by }}/image" alt="User photo"> --}}
            <img class="w-8 h-8" src="{{ url('images/profile.png') }}" alt="User photo">
            <a class="p-1" href="/users/{{ $post->id_created_by }}">{{ $post->createdBy->username }}</a>
            <span class="date m-1">{{ $post->created_at }}</span>
        </div>
        @if ($editable)
            <div class="m-1 flex">
                <a href="#" class="edit edit-post m-1">&#9998;</a>
                <a href="{{ url('home') }}" class="delete delete-post m-1">&#10761;</a>
            </div>
        @endif
    </header>
    <div class='post-body row-start-2 col-start-1 flex flex-col gap-4'>
        @if ($editable)
            @include('partials.create_post_form', ['formClass' => 'edit-post-info hidden', 'textPlaceholder' => 'Edit post', 'contentValue' => $post->content, 'buttonText' => 'Update Post'])
        @endif
        <a class="flex flex-col gap-4" href="/post/{{ $post->id }}">
            <p class='post-content'>{{ $post->content }}</p>
            @if ($post->media != null)
                <div class="image-container relative">
                    <img src="{{ route('post.image', ['id' => $post->id]) }}" alt="A post image">
                    @if ($editable)
                        <a href="#" class="delete delete-image absolute top-0 right-0 py-1 px-2" data-id="{{ $post->id }}">&#10761;</a>
                    @endif
                </div>
            @endif
        </a>
    </div>
    <div class="post-footer row-start-3 col-start-1 col-span-3 flex justify-between">
        <h3 class="col-start-1 flex">
            <a href="#" class="like">&#10084;</a>
            <span class="likes">{{ $post->likes->count() }}</span>
        </h3>
        <span class="nr-comments after:content-['_comments']">{{ $post->comments->count() }}</span>
    </div>
</div>
