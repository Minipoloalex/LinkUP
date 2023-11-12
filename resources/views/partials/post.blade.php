<article class="post" data-id="{{ $post->id }}">
    <header>
        <h2><a href="/users/{{ $post->id_created_by }}">{{ $post->createdBy->username }}</a></h2>
        <h3><!--Put here the number of likes of the post-->
            <a href="#" class="like">&#10084;>
                <span class="likes">{{ $post->likes->count() }}</span>
            </a>
        </h3>
        <a href="#" class="delete">&#10761;</a>
    </header>
    <p>{{ $post->content }}</p>
    @php
        $comments = $post->comments;
    @endphp
    <h4>
        <span class="nr-comments">{{ $comments->count() }}</span>
    </h4>
    @if($displayComments)
        @if ($comments->count() > 0)
            <ul class='comments'>
                <!-- or just pass to partials.post again -->
                @each('partials.post', $comments, 'post', ['displayComments' => false])
            </ul>
        @else
            <p>No comments yet</p>
        @endif
    @endif
    <form class="new_comment">
        <input type="text" name="description" placeholder="Add a comment">
    </form>
</article>
