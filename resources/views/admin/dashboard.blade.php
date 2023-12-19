@extends('layouts.admin')

@section('content')
<div class="flex flex-col px-6 py-4 justify-center items-center w-full">
    <div class="my-10">
        <div class="flex my-6">
            <a class="text-xl mr-2 hover:underline" href="{{ route('admin.users') }}">Manage Users</a>
            <div class="flex items-center justify-center ml-2">
                <i class="fa-solid fa-chevron-right fa-xl text-dark-active"></i>
            </div>
        </div>
        <div class="flex my-6">
            <a class="text-xl mr-2 hover:underline" href="{{ route('admin.groups') }}">Manage Groups</a>
            <div class="flex items-center justify-center ml-2">
                <i class="fa-solid fa-chevron-right fa-xl text-dark-active"></i>
            </div>
        </div>
        <div class="flex my-6">
            <a class="text-xl mr-2 hover:underline" href="{{ route('admin.posts') }}">Manage Posts</a>
            <div class="flex items-center justify-center ml-2">
                <i class="fa-solid fa-chevron-right fa-xl text-dark-active"></i>
            </div>
        </div>
        <div class="flex my-6">
            <a class="text-xl mr-2 hover:underline" href="{{ route('admin.create') }}">Create Admin</a>
            <div class="flex items-center justify-center ml-2">
                <i class="fa-solid fa-chevron-right fa-xl text-dark-active"></i>
            </div>
        </div>
    </div>
</div>
@endsection