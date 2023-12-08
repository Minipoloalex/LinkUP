{{--
['group' => Group object]
--}}
<a href="{{ url("/group/" . $group->id) }}" class="flex gap-4 items-center border-2 p-5">
    <img class="w-8 h-8 rounded-full" src="{{ $group->getPicture() }}" alt="Group Picture">    
    <div class="flex flex-col">
        <p class="font-bold">{{ $group->name }}</p>
        <p class="text-gray-600">{{ $group->description ?? '' }}</p>
    </div>
</a>
