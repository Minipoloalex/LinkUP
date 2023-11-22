@extends('layouts.admin')

@section('content')
<div class="flex flex-col px-6 py-4 content-center justify-center items-center">
    <h2 class="text-xl">Welcome, {{ auth()->user()->name }}</h2>
    <div class="my-10">
        <div class="flex my-6">
            <a class="text-xl mr-2 hover:underline" href="{{ route('admin.users') }}">Manage Users</a>
            <img src="{{ url('images/icons/login.png') }}" alt="Show users" class="w-6">
        </div>
        <div class="flex my-6">
            <a class="text-xl mr-2 hover:underline" href="{{ route('admin.posts') }}">Manage Posts</a>
            <img src="{{ url('images/icons/login.png') }}" alt="Show posts" class="w-6">
        </div>
        <div class="flex my-6">
            <a class="text-xl mr-2 hover:underline" href="{{ route('admin.create') }}">Create Admin</a>
            <img src="{{ url('images/icons/login.png') }}" alt="Create a new admin" class="w-6">
        </div>
    </div>
</div>
@endsection
