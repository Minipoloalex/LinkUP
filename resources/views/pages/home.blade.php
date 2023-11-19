@extends('layouts.app')

@section('title', 'Home')

@section('content')
<section id="timeline" class="flex flex-col flex-grow w-max">
    <!-- Javascript will render posts here -->
    <div id="fetcher" class="loader">
        <div class="spinner-border text-primary" role="status">
            <span class="sr-only">Loading...</span>
        </div>
        <p>Loading posts...</p>
    </div>
</section>
@endsection