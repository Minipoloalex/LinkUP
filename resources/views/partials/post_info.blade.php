<header>
    <h2><a href="/users/{{ $post->id_created_by }}">{{ $post->createdBy->username }}</a></h2>
    <h3>
        <a href="#" class="like">&#10084;</a>
        <span class="likes">{{ $post->likes->count() }}</span>
    </h3>
    <h3>
        <span class="date">{{ $post->created_at }}</span>
    </h3>
    @if ($post->isCreatedByCurrentUser())
        <a href="#" class="edit edit-post">&#9998;</a>
        <form class="edit-content hidden">
            <input class='textfield' type="text" name="content" value="{{ $post->content }}">
        </form>
        <a href="#" class="delete">&#10761;</a>
    @endif
</header>
<p class='post-content'>{{ $post->content }}</p>
<h4>
    <span class="nr-comments">{{ $post->comments->count() }}</span>
</h4>
