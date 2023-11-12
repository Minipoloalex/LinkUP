<article class="post" data-id="{{ $post->id }}">
    @include('partials.post_info', ['post' => $post])
    <!-- <header>
        <h2><a href="/users/{{ $post->id_created_by }}">{{ $post->createdBy->username }}</a></h2>
        <h3>
            <a href="#" class="like">&#10084;>
                <span class="likes">{{ $post->likes->count() }}</span>
            </a>
        </h3>
        <h3>
            <span class="date">{{ $post->created_at }}</span>
        </h3>
        <a href="#" class="delete">&#10761;</a>
    </header>
    <p>{{ $post->content }}</p>
    @php
        $comments = $post->comments;
    @endphp
    <h4>
        <span class="nr-comments">{{ $comments->count() }}</span>
    </h4> -->
    @if($displayComments)
        @php
            $comments = $post->comments;
        @endphp
        @if ($comments->count() > 0)
            <ul class='comments'>
                <!-- or just pass to partials.post again -->
                @each('partials.comment', $comments, 'comment', ['displayComments' => false])
            </ul>
        @else
            <p>No comments yet</p>
        @endif
    @endif
    <form class="new_comment">
        <input type="text" name="description" placeholder="Add a comment">
    </form>
</article>
