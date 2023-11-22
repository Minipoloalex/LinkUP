<article class="post w-full" data-id="{{ $post->id }}">
    @include('partials.post_info', ['post' => $post, 'showEdit' => $showEdit])
    @if($displayComments)
        @php
            $comments = $post->comments;
        @endphp
        
        <div class='comments-container'>
            @if ($comments->count() > 0)
                @foreach ($comments as $comment)
                    @include('partials.comment', ['comment' => $comment, 'displayComments' => false, 'showEdit' => $showEdit])
                @endforeach
            @endif
        </div>
    @endif
    @if ($showEdit)
        @include('partials.create_post_form', ['formClass' => 'add-comment rounded px-10 py-5 bg-gray-300', 'textPlaceholder' => 'Add a new comment', 'buttonText' => 'Create Comment', 'contentValue' => ''])
    @endif
</article>
