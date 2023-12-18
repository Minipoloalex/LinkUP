<div class="image-container flex items-center justify-center">
    <a class="post-link" href="{{ $linkTo }}">
        <img src="{{ route('post.image', ['id' => $post->id, 'date' => time()]) }}" alt="A post image">
    </a>
    @if ($editable)
    <a href="#" class="delete delete-image" data-id="{{ $post->id }}">&#10761;</a>
    @endif
</div>