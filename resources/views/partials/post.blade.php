<article class="post" data-id="{{ $post->id }}">
    @include('partials.post_info', ['post' => $post])
    @if($displayComments)
        @php
            $comments = $post->comments;
        @endphp
        @if ($comments->count() > 0)
            <div class='comments-container'>
                @each('partials.comment', $comments, 'comment', ['displayComments' => false])
            </div>
        @else
            <p>No comments yet</p>
        @endif
    @endif
    @include('partials.create_post_form', ['type' => 'comment'])
</article>
