<div class="image-container flex items-center justify-center">
    <div class="relative">
        <a class="post-link" href="{{ $linkTo }}">
            <img src="{{ route('post.image', ['id' => $post->id, 'date' => time()]) }}" alt="A post image">
        </a>
        @if ($editable)
        <a href="#"
            class="absolute top-1 right-1 h-6 w-6 flex items-center justify-center delete delete-image dark:bg-dark-primary rounded-full"
            data-id="{{ $post->id }}">
            <i class="fas fa-times"></i>
        </a>
        @endif
    </div>
</div>