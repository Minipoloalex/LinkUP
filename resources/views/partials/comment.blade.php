@php
$showGroupOwnerDelete ??= false;
@endphp
<article class="comment" data-id="{{ $comment->id }}">
    @include('partials.post_info', ['post' => $comment, 'showEdit' => $showEdit,
    'showGroupOwnerDelete' => $showGroupOwnerDelete, 'hasAdminLink' => $hasAdminLink,
    'hasAdminDelete' => $hasAdminDelete])
</article>
