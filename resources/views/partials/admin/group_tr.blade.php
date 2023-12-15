<tr class="group-tr">
    <td>{{ $group->id }}</td>
    <td>{{ $group->name }}</td>
    <td>{{ $group->owner->name }}</td>
    <td>{{ $group->members->count() }}</td>
    <td>
        <form action="{{ route('admin.groups.delete', $group->id) }}" method="POST">
            @csrf
            <button type="submit" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">Delete</button>
        </form>
    </td>
</tr>
