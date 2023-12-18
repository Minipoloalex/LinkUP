{{-- ['post' => Post Model, 'displayComments' => bool, 'showAddComment' => bool, 'showEdit' => bool, 'hasAdminLink' =>
?bool, 'hasAdminDelete' => ?bool, 'showGroupOwnerDelete' => ?bool] --}}
@php
$showGroupOwnerDelete ??= false;
$hasAdminLink ??= false;
$hasAdminDelete ??= false;
@endphp
<article class="post p-2 border-t dark:border-dark-neutral first:border-0 w-full" data-id="{{ $post->id }}">
    @include('partials.post_info', ['post' => $post, 'showEdit' => $showEdit,
    'showGroupOwnerDelete' => $showGroupOwnerDelete, 'hasAdminLink' => $hasAdminLink,
    'hasAdminDelete' => $hasAdminDelete])
    @if($displayComments)
    @php
    $comments = $post->comments;
    @endphp

    @auth
    @if ($showAddComment)
    @include('partials.create_post_form', ['formClass' => 'add-comment rounded px-10 py-5 bg-gray-300',
    'textPlaceholder' => 'Add a new comment', 'buttonText' => 'Comment', 'contentValue' => ''])
    @endif
    @endauth

    <div class='comments-container py-4'>
        @if ($comments->count() > 0)
        @foreach ($comments as $comment)
        @include('partials.comment', ['comment' => $comment, 'displayComments' => false, 'showEdit' => $showEdit,
        'showGroupOwnerDelete' => $showGroupOwnerDelete, 'hasAdminLink' => $hasAdminLink,
        'hasAdminDelete' => $hasAdminDelete])
        @endforeach
        @endif
    </div>
    @endif
</article>