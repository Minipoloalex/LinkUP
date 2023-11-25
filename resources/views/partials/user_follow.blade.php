<article class="border-2 p-5">
    <a href="{{ url("/profile/" . $user->username) }}" class="user-follow flex gap-4 items-center">
        <img class="w-8 h-8" src="{{ $user->getProfilePicture() }}" alt="Profile Picture">
        <p>{{ $user->username }}</p>
    </a>
</article>
