{{--
['group' => Group object]
--}}
<article class="border-2 p-5 flex justify-between">
    <a href="{{ url("/group/" . $group->id) }}" class="flex gap-4 items-center">
        <img class="w-8 h-8 rounded-full" src="{{ $group->getPicture() }}" alt="Group Picture">    
        <div class="flex flex-col">
            <p class="font-bold">{{ $group->name }}</p>
            <p class="text-gray-600">{{ $group->description ?? '' }}</p>
        </div>
    </a>
</article>