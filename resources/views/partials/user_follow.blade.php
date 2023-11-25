{{--
['user' => ..., 'type' => string, 'editable' => bool]  $type = "follower" or "following"
--}}
<article class="border-2 p-5 flex justify-between">
    <a href="{{ url("/profile/" . $user->username) }}" class="user-follow flex gap-4 items-center">
        <img class="w-8 h-8" src="{{ $user->getProfilePicture() }}" alt="Profile Picture">
        <p>{{ $user->username }}</p>
    </a>
    @auth
        @if ($editable)
            <button data-id="{{ $user->id }}" data-username="{{ $user->username }}" class="delete-{{$type}} justify-end p-2">X</button>
        @endif
    @endauth
</article>
