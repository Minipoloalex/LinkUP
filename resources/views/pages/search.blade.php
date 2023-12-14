@extends('layouts.app')

@section('title', 'Search')
@section('content')
<main id="search-page" class="  flex flex-col w-screen overflow-clip overflow-y-scroll relative h-[calc(100vh-10rem)]
                                lg:w-full lg:h-[calc(100vh-6rem)]">
    <div class="border-b-2 dark:border-dark-neutral dark:bg-dark-primary pb-4 sticky top-0 left-0">
        <section id="search-content" class="flex gap-2">
            <div class="w-full flex p-2">
                <header class="flex w-1/4 items-center justify-center">
                    <h1 class="text-xl font-bold text-center mt-2">Search:</h1>
                </header>
                @include('partials.header.search-bar')
            </div>
        </section>
        @include('partials.search.search_filters_side')
    </div>
    <div>
        <div id="results-container" data-page="0"></div>
        <div id="fetcher"></div>
    </div>
</main>
@endsection