@extends('layouts.admin')

@section('content')
<header class="flex content-center justify-between items-center px-6 py-4">
    <img src="{{ url('images/logo.png') }}" alt="Link up logo" class="w-24">
    <div class="w-42">
        <h1 class="text-2xl">Admin Dashboard</h1>
    </div>
    <div class="w-24">
        <a href="{{ route('admin.logout') }}" class="text-slate-200 hover:text-white">
            <img src="{{ url('images/icons/logout.png') }}" alt="Logout" class="w-6">
        </a>
    </div>
</header>
<div class="flex flex-col px-6 py-4 content-center justify-center items-center">
    <h2 class="text-xl">Welcome, {{ auth()->user()->name }}</h2>
    <div class="my-10">
        <div class="flex my-6">
            <a class="text-xl mr-2 hover:underline" href="{{ route('admin.users') }}">Manage Users</a>
            <img src="{{ url('images/icons/login.png') }}" alt="Show users" class="w-6">
        </div>
        <div class="flex my-6">
            <a class="text-xl mr-2 hover:underline" href="{{ route('admin.posts') }}">Manage Posts</a>
            <img src="{{ url('images/icons/login.png') }}" alt="Show users" class="w-6">
        </div>
    </div>
</div>

@endsection