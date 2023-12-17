{{--
['group' => Group object, 'isOwner' => bool]
--}}
@php
$linkTo ??= route('group.show', ['id' => $group->id]);
@endphp
<a href="{{ $linkTo }}"
    class="flex gap-3 items-center p-5 border-t dark:border-dark-neutral first:border-0">
    <img class="w-8 h-8 rounded-full" src="{{ $group->getPicture() }}" alt="Group Picture">
    <div class="flex flex-col">
        <p class="font-bold">{{ $group->name }}</p>
        <p>{{ $group->description ?? '' }}</p>
    </div>
    @if ($isOwner)
    <div class="grow text-right mr-4">
        <span class="text-right border-2 p-2 rounded-full">Owner</span>
    </div>
    @endif
</a>