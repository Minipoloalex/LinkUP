@extends('layouts.app')

@section('title', 'Search')
@section('content')
<main id="searchpage" class="grid grid-cols-4 absolute top-32 left-0 w-screen px-64">
    @include('partials.side.navbar')
    <section id="results-container" class="col-span-2">
        <p class="flex justify-center">No results found</p>
    </section>
    @include('partials.side.notifications-tab')
</main>
@endsection
