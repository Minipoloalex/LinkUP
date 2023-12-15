@extends('layouts.admin')

@section('content')
<div class="flex mt-4 content-center justify-center items-center w-full mx-auto">
    <table class="w-2/3 border border-slate-300">
        <thead class="text-xl text-left">
            <tr>
                <th>Group Id</th>
                <th>Name</th>
                <th>Owner</th>
                <th>Members</th>
            </tr>
        </thead>

        <tbody>
            @foreach($groups as $group)
            <tr>
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
            @endforeach
        </tbody>

    </table>
</div>

<div class="flex justify-center items-center w-full mt-12 mx-auto">
    {{ $groups->links() }}
</div>

@endsection