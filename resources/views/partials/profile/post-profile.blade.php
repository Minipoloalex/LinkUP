@php
    $userCanSeePosts =  ($user->id === Auth::user()->id || Auth::user()->isFollowing($user)) || $user->is_private === false;
@endphp

@if($userCanSeePosts)

    @foreach($user->posts as $post)
        @include('partials.post', ['post' => $post, 'displayComments' => false, 'showEdit' => false])
    @endforeach

@else
    <p class="text-center">This user has a private profile.</p>
@endif