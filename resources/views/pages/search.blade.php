@extends('layouts.app')

@section('title', 'Search')

@section('content')
    <section id="search-content">
        <header>
            <h2>Search for a post</h2>
            <form id="search-form">
                <input id="search" type="text" placeholder="Search for a post">
                <button id="search-button">Submit</button>
            </form>
        </header>
        <div id="results-container">
            <p class="empty">No results found</p>
        </div>
    </section>
@endsection
