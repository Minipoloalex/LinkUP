@php
$activePage = 'search';
@endphp
@extends('layouts.app')

@push('scripts')
<script type="module" src="{{ url('js/search.js') }}"></script>
@endpush

@section('title', 'Search')
@section('content')
<main id="search-page" class="  flex flex-col w-screen overflow-clip overflow-y-scroll scrollbar-hide relative h-[calc(100vh-10rem)]
                                lg:w-full lg:h-[calc(100vh-6rem)]">
    <div class="dark:bg-dark-primary mt-4 sticky">
        <section id="search-content" class="flex gap-2">
            <div class="w-full flex p-2">
                <div class="h-[5vh] w-full flex flex-col justify-center">
                    <form id="search-form" class="self-center flex content-center justify-center py-1 rounded-full group"
                        action="{{ url('/search') }}" method="GET">
                        <div class="rounded-full bg-transparent h-10 flex items-center justify-center border-2 border-dark-active">
                            <button type="submit"><i class="fas fa-search text-white ml-3"></i></button>
                            <input id="search-text" class="align-middle w-full bg-transparent ml-2 mr-3 text-white font-normal text-sm
                            focus:outline-none" type="text" name="query" placeholder="Search"
                                    autocomplete="off">
                        </div>
                    </form>
                </div>
            </div>
        </section>
        @include('partials.search.search_filters')
    </div>
    <div class="overflow-y-scroll">
        <div id="results-container" data-page="0"></div>
        <div id="fetcher"></div>
    </div>
</main>
@endsection