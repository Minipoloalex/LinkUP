@php
$group = App\Models\Group::find($group->id);
$group_link = route('group.show', ['id' => $group->id]);
$gp = $group->getPicture();
if (isset($group->description) && strlen($group->description) > 30) $group->description = substr($group->description, 0,
30) . '...';
@endphp

<div class="flex items-center w-full h-14 p-1 border-t dark:border-dark-neutral first:border-0">
    <div class="h-12 min-w-[2rem] flex items-center justify-center ml-2">
        <a href="{{ $group_link }}">
            <img src="{{ $gp }}?v={{ time() }}" alt="avatar" class="w-8 h-8 rounded-full">
        </a>
    </div>
    <a href="{{ $group_link }}" class="flex flex-col items-start justify-center h-12 ml-2 text-xs">
        <div class="font-bold flex items-center dark:text-dark-active">
            <h2>{{ $group->name }}</h2>
        </div>
        <div>
            <h2>{{ $group->description }}</h2>
        </div>
    </a>
</div>