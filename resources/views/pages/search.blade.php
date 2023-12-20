@php
$activePage = 'search';
@endphp
@extends('layouts.app')

@push('scripts')
<script type="module" src="{{ url('js/search.js') }}"></script>
@endpush

@section('title', 'Search')
@section('content')
<main id="search-page" class="  flex flex-col w-screen overflow-clip overflow-y-scroll scrollbar-hide relative h-[calc(100vh-9rem)]
                                lg:w-full lg:h-[calc(100vh-6rem)]">
    <div class="dark:bg-dark-primary mt-4">
        <section id="search-content" class="flex gap-2">
            <div class="w-full flex p-2 items-center justify-center">
                <div class="w-2/3 flex flex-col justify-center items-center">
                    <form id="search-form" class="flex flex-col justify-center items-center py-1 rounded-full w-full"
                        action="{{ url('/search') }}" method="GET">
                        <div class="w-full flex items-center justify-center">
                            <div
                                class="rounded-full bg-transparent h-10 flex items-center justify-center border-2 border-dark-active flex-grow">
                                <button type="submit"><i class="fas fa-search text-white ml-3"></i></button>
                                <input id="search-text" class="align-middle w-full bg-transparent ml-2 mr-3 text-white font-normal text-sm
                            focus:outline-none" type="text" name="query" placeholder="Search" autocomplete="off">
                            </div>
                            <div id="advanced-search-button"
                                class="h-full w-8 flex items-center justify-center ml-2 cursor-pointer">
                                <i class="fa-solid fa-sliders"></i>
                            </div>
                        </div>
                        <div id="advanced-filters" class="  advanced-inactive w-full gap-2 flex flex-col items-center justify-center h-[10vh]
                                                            transition-all duration-300 ease-in-out mt-6">
                            <div class="w-full flex flex-col items-center justify-center gap-2">
                                @include('partials.search.advanced-filters')
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </section>
        @include('partials.search.search_filters')
    </div>
    <div class=" overflow-y-auto">
        <div id="results-container" data-page="0"></div>
        <div id="fetcher"></div>
    </div>
</main>
@endsection