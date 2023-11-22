@extends('layouts.app')

@section('title', 'Search')
@section('content')
<main id="searchpage" class="grid grid-cols-4 absolute top-32 left-0 w-screen px-64">
    @include('partials.side.navbar')
    <section id="results-container" class="col-span-2">
        @if ($posts->count() == 0)
            <p class="flex justify-center">No results found</p>        
        @else
            @foreach($posts as $post)
                @include('partials.post', ['post' => $post, 'displayComments' => false, 'showEdit' => false])
            @endforeach
        @endif
    </section>
    @include('partials.side.notifications-tab')
</main>
@endsection
