@extends('layouts.app')

@section('title', 'Search')
@section('content')
<main id="search-page" class="grid grid-cols-4 absolute top-32 left-0 w-screen px-64">
    @include('partials.side.navbar')
    <section id="search-content" class="col-span-2 flex flex-col gap-6">
        <header class="flex flex-col gap-4">
            <h1 class="text-2xl font-bold">Search for users, groups, posts or comments</h1>
            @include('partials.header.search-bar')
        </header>
        <section id="search-filters">
            <header><h2>Search for:</h2></header>
            <ul class="flex flex-col">
                <li class="flex gap-2">
                    <input type="radio" id="posts-radio" name="search-type" value="posts" checked>
                    <label for="posts-radio">Posts</label>
                </li>
                <li class="flex gap-2">
                    <input type="radio" id="comments-radio" name="search-type" value="comments">
                    <label for="comments-radio">Comments</label>
                </li>
                <li class="flex gap-2">
                    <input type="radio" id="users-radio" name="search-type" value="users">
                    <label for="users-radio">Users</label>
                </li>
                <li class="flex gap-2">
                    <input type="radio" id="groups-radio" name="search-type" value="groups">
                    <label for="groups-radio">Groups</label>
                </li>
            </div>
        </section>
        <div id="results-container"></div>
        {{-- @if ($posts->count() == 0)
            <p class="flex justify-center">No results found</p>
        @else
            @foreach($posts as $post)
                @include('partials.post', ['post' => $post, 'displayComments' => false, 'showEdit' => false])
            @endforeach
        @endif --}}
    </section>
    @include('partials.side.notifications-tab')
</main>
@endsection
