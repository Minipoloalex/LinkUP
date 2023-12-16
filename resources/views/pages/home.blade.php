@extends('layouts.app')
@section('title', 'Home')

@push('scripts')
<script type="module" src="{{ url('js/home/home.js') }}"></script>
<script type="module" src="{{ url('js/home/notifications.js') }}"></script>
<script type="module" src="{{ url('js/home/suggestions.js') }}"></script>
@endpush

@section('content')
@include('partials.header.timeline-tabs')
<main id="homepage" class=" flex flex-col w-screen overflow-clip overflow-y-scroll h-[calc(100vh-10rem)] scrollbar-hide
                            lg:w-full">

    <section class="flex overflow-clip overflow-y-auto" id="content">
        <section id="timeline" class="flex flex-col w-screen max-h-min overflow-clip" data-page="0">
            <!-- Javascript will render posts here -->
            <div id="fetcher" class="h-16 lg:h-0"></div>
        </section>
    </section>
    <div id="dark-overlay" class="hidden fixed top-0 left-0 w-full h-full bg-black z-10" style="opacity: 0.8;"></div>

    @auth
    <div id="create-post" class="relative z-20">
        @include('partials.create_post_form', [
        'formClass' => 'add-post w-full lg:w-2/3 xl:w-1/2 xl:w-1/3 hidden fixed bottom-1/2 left-1/2 transform
        -translate-x-1/2 bg-gray-200 rounded px-10 py-5',
        'textPlaceholder' => 'Add a new post', 'buttonText' => 'Create Post', 'contentValue' => ''])
    </div>
    @endauth
</main>
@endsection