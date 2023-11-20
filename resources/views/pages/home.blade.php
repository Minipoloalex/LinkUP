@extends('layouts.app')

@section('title', 'Home')

@section('content')
<section id="timeline" class="flex flex-col flex-grow w-max max-h-min">
    <!-- Javascript will render posts here -->
    <div id="fetcher">
        <p class="text-center">Loading...</p>
    </div>
</section>
@endsection