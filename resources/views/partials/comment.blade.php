<article class="comment" data-id="{{ $comment->id }}">
    @include('partials.post_info', ['post' => $comment, 'showEdit' => $showEdit, 'hasAdminLink' => $hasAdminLink, 'hasAdminDelete' => $hasAdminDelete])
</article>
