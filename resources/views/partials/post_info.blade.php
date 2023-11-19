<div class="post-info">
    <header>
        <h2><a href="/users/{{ $post->id_created_by }}">{{ $post->createdBy->username }}</a></h2>
        <h3>
            <a href="#" class="like">&#10084;</a>
            <span class="likes">{{ $post->likes->count() }}</span>
        </h3>
        <h3>
            <span class="date">{{ $post->created_at }}</span>
        </h3>
        @php
            $editable = $post->isCreatedByCurrentUser();
        @endphp
        @if ($editable)
            <a href="#" class="edit edit-post">&#9998;</a>
            <a href="{{ url('home') }}" class="delete delete-post">&#10761;</a>
        @endif
    </header>
    <div class='post-body'>
        @if ($editable)
            @include('partials.create_post_form', ['formClass' => 'edit-post-info hidden', 'textPlaceholder' => 'Edit post', 'contentValue' => $post->content, 'buttonText' => 'Update Post'])
        @endif
        <p class='post-content'>{{ $post->content }}</p>
        @if ($post->media != null)
            <div class="image-container">
                <img src="{{ route('post.image', ['id' => $post->id]) }}" alt="A post image">
                @if ($editable)
                    <a href="#" class="delete delete-image" data-id="{{ $post->id }}">&#10761;</a>
                @endif
            </div>
        @endif
    </div>
    <h4>
        <span class="nr-comments">{{ $post->comments->count() }}</span>
    </h4>
</div>
