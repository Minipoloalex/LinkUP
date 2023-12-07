@php
    $userCanSeePosts = $user->is_private === false || (Auth::check() && ($user->id === Auth::user()->id || Auth::user()->isFollowing($user)));
@endphp

@if($userCanSeePosts)

    @foreach($user->posts as $post)
        @include('partials.post', ['post' => $post, 'displayComments' => false, 'showAddComment' => false, 'showEdit' => false])
    @endforeach

@else
    <p class="text-center">This user has a private profile.</p>
@endif