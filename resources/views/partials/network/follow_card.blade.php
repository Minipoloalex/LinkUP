{{--
['user' => ..., 'buttons' => array, 'isMyProfile' => bool, 'linkTo' => route(...)]
buttons = [['class' => ..., 'text' => ...], ...]
--}}
<article class="border-t dark:border-dark-neutral p-5 flex justify-between first:border-0">
    <a href="{{ $linkTo }}" class="user-follow flex gap-4 items-center">
        <img class="w-8 h-8 rounded-full" src="{{ $user->getProfilePicture() }}?v={{ time() }}" alt="Profile Picture">
        <div class="flex flex-col">
            <p class="font-bold">{{ $user->name }}</p>
            <p>{{ $user->username }}</p>
        </div>
    </a>
    @auth
    @if ($isMyProfile)
    <div class="flex flex-row">
        @foreach($buttons as $button)
        <button data-id="{{ $user->id }}" data-username="{{ $user->username }}"
            class="{{ $button['class'] }} user-{{ $user->id}} justify-end p-2">{{ $button['text'] }}</button>
        @endforeach
    </div>
    @endif
    @endauth
</article>