{{--
['group' => Group object, 'isOwner' => bool, 'buttons' => ? array]
--}}
@php
$linkTo ??= route('group.show', ['id' => $group->id]);
$buttons ??= null;
@endphp
<a href="{{ $linkTo }}"
    class="group-card flex gap-3 items-center p-5 border-t dark:border-dark-neutral first:border-0">
    <img class="w-8 h-8 rounded-full" src="{{ $group->getPicture() }}?v={{ time() }}" alt="Group Picture">
    <div class="flex flex-col">
        <p class="font-bold">{{ $group->name }}</p>
        <p>{{ $group->description ?? '' }}</p>
    </div>
    @if ($isOwner)
    <div class="grow text-right mr-4">
        <span class="text-right border-2 p-2 rounded-full">Owner</span>
    </div>
    @elseif ($buttons !== null)
    <div class="flex flex-row">
        @foreach($buttons as $button)
        <button data-id="{{ $user->id }}" data-group-id="{{ $group->id }}" data-group-name="{{ $group->name }}"
            class="{{ $button['class'] }} user-{{ $user->id}} justify-end p-2">{{ $button['text'] }}</button>
        @endforeach
    </div>
    @endif
</a>