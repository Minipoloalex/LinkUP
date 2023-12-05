@extends('layouts.admin')

@section('content')
<div class="flex mt-4 content-center justify-center items-center w-full mx-auto">
    <table class="w-2/3 border border-slate-300">
        <thead class="text-xl text-left">
            <tr>
                <th class="w-12">Id</th>
                <th>Username</th>
                <th>Name</th>
                <th>Email</th>
            </tr>
        </thead>
        <tbody>
            @foreach($users as $user)
            <tr>
                <td>{{ $user->id }}</td>
                <td>{{ $user->username }}</td>
                <td>{{ $user->name }}</td>
                <td>{{ $user->email }}</td>
                <td>
                    @if($user->is_banned)
                    <form action="{{ route('admin.users.unban', $user->id) }}" method="POST">
                        @csrf
                        <button type="submit" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">Unban</button>
                    </form>
                    @else
                    <form action="{{ route('admin.users.ban', $user->id) }}" method="POST">
                        @csrf
                        <button type="submit" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">Ban</button>
                    </form>
                    @endif
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

{{ $users->links() }}

@endsection