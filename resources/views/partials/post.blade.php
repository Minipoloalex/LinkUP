<article class="post w-full" data-id="{{ $post->id }}">
    @include('partials.post_info', ['post' => $post])
    @if($displayComments)
        @php
            $comments = $post->comments;
        @endphp
        @if ($comments->count() > 0)
            <div class='comments-container'>
                @each('partials.comment', $comments, 'comment', ['displayComments' => false])
            </div>
        @endif
    @endif
    @include('partials.create_post_form', ['formClass' => 'add-comment rounded px-10 py-5 bg-gray-300', 'textPlaceholder' => 'Add a new comment', 'buttonText' => 'Create Comment', 'contentValue' => ''])
</article>
