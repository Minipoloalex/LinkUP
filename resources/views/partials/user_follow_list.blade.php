{{--
['user' => ..., 'buttons' => array]  buttons = [['class' => ..., 'text' => ...], ...]
--}}
<article class="border-2 p-5 flex justify-between">
    <a href="{{ url("/profile/" . $user->username) }}" class="user-follow flex gap-4 items-center">
        <img class="w-8 h-8" src="{{ $user->getProfilePicture() }}" alt="Profile Picture">
        <div id="user-info" class="flex flex-col">
            <p class="font-bold">{{ $user->name }}</p>
            <p class="text-gray-600">{{ $user->username }}</p>
        </div>
    </a>
    @auth
        @if ($editable) 
            <div class="flex flex-row">
                @foreach($buttons as $button)
                    <button data-id="{{ $user->id }}" data-username="{{ $user->username }}" class="{{ $button['class'] }} justify-end p-2">{{ $button['text'] }}</button>
                @endforeach
            </div>
        @endif
    @endauth
</article>
