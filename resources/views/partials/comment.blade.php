@php
$showGroupOwnerDelete ??= false;
@endphp
<article class="comment border rounded-md border-dark-active" data-id="{{ $comment->id }}">
    @include('partials.post_info', ['post' => $comment, 'showEdit' => $showEdit,
    'showGroupOwnerDelete' => $showGroupOwnerDelete, 'hasAdminLink' => $hasAdminLink,
    'hasAdminDelete' => $hasAdminDelete])
</article>
