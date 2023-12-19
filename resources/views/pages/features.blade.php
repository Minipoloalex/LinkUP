@php
$activePage = 'features';
@endphp
@extends('layouts.app')
@section('title', 'About')
@section('content')
<main id="about" class="  flex flex-col w-screen overflow-clip overflow-y-scroll h-[calc(100vh-6rem)] scrollbar-hide
                            lg:w-full">

    <header class="mx-12 mt-12">
        <h1 class="text-4xl font-bold text-dark-active">Main Features</h1>
    </header>

    <p class="text-sm mx-12 mt-4">
        The following section describes the main features of LINK UP. 
    </p>

    <section id="main-features" class="flex flex-col mx-12 pb-12">
        <div id="guest">
            <h3 class="text-lg text-gray-300 mt-8">As a guest, you can:</h3>
            <ul class="list-disc list-inside text-dark-active space-y-2 text-sm p-4">
                <li><span class="text-white">Login</span></li>
                <li><span class="text-white">Register</span></li>
                <li><span class="text-white">Recover your password</span></li>
                <li><span class="text-white">View the public feed</span></li>
                <li><span class="text-white">View public profiles</span></li>
                <li><span class="text-white">Search for public content</span></li>
            </ul>
        </div>

        <div id="authenticated-user">
            <h3 class="text-lg text-gray-300 mt-8">As an authenticated user, you can:</h3>
            <ul class="list-disc list-inside text-dark-active space-y-2 text-sm p-4">
                <li><span class="text-white">Logout</span></li>
                <li><span class="text-white">View your profile</span></li>
                <li><span class="text-white">Edit your profile</span></li>
                <li><span class="text-white">Update your profile picture</span></li>
                <li><span class="text-white">Set your profile visibility</span></li>
                <li><span class="text-white">Edit your account information</span></li>
                <li><span class="text-white">Delete your account</span></li>
                <li><span class="text-white">View your notifications</span></li>
                <li><span class="text-white">View your suggestions</span></li>
                <li><span class="text-white">View your network</span></li>
                <li><span class="text-white">Follow public profiles</span></li>
                <li><span class="text-white">Request to follow private profiles</span></li>
                <li><span class="text-white">Unfollow accounts</span></li>
                <li><span class="text-white">Remove followers</span></li>
                <li><span class="text-white">Accept/Reject follow requests</span></li>
                <li><span class="text-white">Create new groups</span></li>
                <li><span class="text-white">Request to join groups</span></li>
                <li><span class="text-white">Accept/Reject group invitations</span></li>
                <li><span class="text-white">View the 'following' feed</span></li>
                <li><span class="text-white">View the 'for you' feed</span></li>
                <li><span class="text-white">Create new posts</span></li>
                <li><span class="text-white">Like/Unlike posts</span></li>
                <li><span class="text-white">Comment on posts</span></li>
                <li><span class="text-white">Search for users, groups, posts and comments</span></li>
            </ul>
        </div>

        <div id="post-author">
            <h3 class="text-lg text-gray-300 mt-8">As the author of a post, you can:</h3>
            <ul class="list-disc list-inside text-dark-active space-y-2 text-sm p-4">
                <li><span class="text-white">Edit the post</span></li>
                <li><span class="text-white">Delete the post</span></li>
                <li><span class="text-white">Manage the post's visibility</span></li>
            </ul>
        </div>

        <div id="group-member">
            <h3 class="text-lg text-gray-300 mt-8">As a member of a group, you can:</h3>
            <ul class="list-disc list-inside text-dark-active space-y-2 text-sm p-4">
                <li><span class="text-white">View the group feed</span></li>
                <li><span class="text-white">Post to the group feed</span></li>
                <li><span class="text-white">View the group members</span></li>
                <li><span class="text-white">Leave the group</span></li>
            </ul>
        </div>

        <div id="group-owner">
            <h3 class="text-lg text-gray-300 mt-8">As the owner of a group, you can:</h3>
            <ul class="list-disc list-inside text-dark-active space-y-2 text-sm p-4">
                <li><span class="text-white">Edit the group information</span></li>
                <li><span class="text-white">Delete the group</span></li>
                <li><span class="text-white">Update the group's owner</span></li>
                <li><span class="text-white">Invite users to join the group</span></li>
                <li><span class="text-white">Accept/Reject join requests</span></li>
                <li><span class="text-white">Remove members from the group</span></li>
                <li><span class="text-white">Remove posts from the group</span></li>
            </ul>
        </div>

        <div id="admin">
            <h3 class="text-lg text-gray-300 mt-8">As an admin, you can:</h3>
            <ul class="list-disc list-inside text-dark-active space-y-2 text-sm p-4">
                <li><span class="text-white">Create new admin accounts</span></li>
                <li><span class="text-white">List all users</span></li>
                <li><span class="text-white">Ban/Unban users</span></li>
                <li><span class="text-white">Delete user accounts</span></li>
                <li><span class="text-white">List all posts</span></li>
                <li><span class="text-white">Delete posts</span></li>
                <li><span class="text-white">List all groups</span></li>
                <li><span class="text-white">Delete groups</span></li>
            </ul>
        </div>

        <div id="additional-features" class="mt-8">
            <h3 class="text-lg text-gray-300 mt-8">Additional features:</h3>
            <ul class="list-disc list-inside text-dark-active space-y-2 text-sm p-4">
                <li><span class="text-white">Responsive design</span></li>
                <li><span class="text-white">Media cropping</span></li>
                <li><span class="text-white">Real-time notifications</span></li>
                <li><span class="text-white">Email notifications</span></li>
                <li><span class="text-white">Placeholders in form fields</span></li>
                <li><span class="text-white">Contextual error messages</span></li>
                <li><span class="text-white">About/Contacts page</span></li>
                <li><span class="text-white">Main features page</span></li>
        </div>
    </section>
</main>
@endsection         