{{--
['group' => Group object]
--}}
@php
$linkTo ??= route('group', ['id' => $group->id]);
@endphp
<a href="{{ $linkTo }}"
    class="flex gap-3 items-center p-5 border-t dark:border-dark-neutral first:border-0">
    <img class="w-8 h-8 rounded-full" src="{{ $group->getPicture() }}" alt="Group Picture">
    <div class="flex flex-col">
        <p class="font-bold">{{ $group->name }}</p>
        <p>{{ $group->description ?? '' }}</p>
    </div>
</a>