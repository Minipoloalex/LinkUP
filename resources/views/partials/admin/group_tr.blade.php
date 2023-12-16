@php
$userLink = route('admin.user', ['username' => $group->owner->username]);
$groupLink = route('admin.group', ['id' => $group->id]);
@endphp
<tr class="group-tr">
    <td>
        <a href="{{ $groupLink }}">{{ $group->id }}</a>  {{-- Do not place the link outside of the <td> element. --}}
    </td>
    <td>
        <a href="{{ $groupLink }}">{{ $group->name }}</a>
    </td>
    <td>
        <a href="{{ $userLink }}">{{ $group->owner->name }}</a>
    </td>
    <td>
        <a href="{{ $groupLink }}">{{ $group->members->count() }}</a>
    </td>
    <td>
        <form action="{{ route('admin.groups.delete', $group->id) }}" method="POST">
            @csrf
            <button type="submit" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">Delete</button>
        </form>
    </td>
</tr>
