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
        <div>
            <div id="results-container" data-page="0"></div>
            <div id="fetcher"></div>
        </div>
    </section>
    @include('partials.search.search_filters_side')
</main>
@endsection
