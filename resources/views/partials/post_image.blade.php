<div class="image-container">
    <img src="{{ route('post.image', ['id' => $post->id, 'date' => time()]) }}" alt="A post image">
    @if ($editable)
        <a href="#" class="delete delete-image" data-id="{{ $post->id }}">&#10761;</a>
    @endif
</div>
