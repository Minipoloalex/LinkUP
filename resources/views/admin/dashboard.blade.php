@extends('layouts.admin')

@section('content')
<div class="flex flex-col px-6 py-4 justify-center items-center w-full">
    <div class="self-center my-10 grid grid-cols-2 grid-rows-2 gap-16">
        <div class="flex flex-col p-8 border-dark-active border-4 rounded-lg shadow-lg">
            <a class="text-xl" href="{{ route('admin.users') }}">
                Manage Users
                <i class="fa-solid fa-user ml-2 text-dark-active"></i>
            </a>
            <p class="text-sm pt-8 pb-4 w-[250px]">List and search users. Ban/Unban and Delete user accounts.</p>
        </div>
        
        <div class="flex flex-col p-8 border-dark-active border-4 rounded-lg shadow-lg">
            <a class="text-xl" href="{{ route('admin.groups') }}">
                Manage Groups
                <i class="fa-solid fa-users text-dark-active ml-2"></i>
            </a>
            <p class="text-sm pt-8 pb-4 w-[250px]">List and search groups. Delete groups.</p>
        </div>
        
        <div class="flex flex-col p-8 border-dark-active border-4 rounded-lg shadow-lg">
            <a class="text-xl" href="{{ route('admin.posts') }}">
                Manage Posts
                <i class="fa-solid fa-newspaper text-dark-active ml-2"></i>
            </a>
            <p class="text-sm pt-8 pb-4 w-[250px]">List and search posts. Delete posts.</p>
        </div>
        
        <div class="flex flex-col p-8 border-dark-active border-4 rounded-lg shadow-lg">
            <a class="text-xl" href="{{ route('admin.create') }}">
                Create Admin
                <i class="fa-solid fa-users text-dark-active ml-2"></i>
            </a>
            <p class="text-sm pt-8 pb-4 w-[250px]">Create new admin account.</p>
        </div>
    </div>
</div>
@endsection