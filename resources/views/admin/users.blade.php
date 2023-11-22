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
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection