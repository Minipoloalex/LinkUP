<article class="post w-full" data-id="{{ $post->id }}">
    @include('partials.post_info', ['post' => $post])
    @if($displayComments)
        @php
            $comments = $post->comments;
        @endphp
        
        <div class='comments-container'>
            @if ($comments->count() > 0)
                @each('partials.comment', $comments, 'comment', ['displayComments' => false])
            @endif
        </div>
    @endif
    @include('partials.create_post_form', ['formClass' => 'add-comment rounded px-10 py-5 bg-gray-300', 'textPlaceholder' => 'Add a new comment', 'buttonText' => 'Create Comment', 'contentValue' => ''])
</article>
