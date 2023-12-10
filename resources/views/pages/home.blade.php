@extends('layouts.app')
@section('title', 'Home')
@section('content')
@include('partials.header.timeline-tabs')
<main id="homepage" class=" flex flex-col w-screen overflow-clip overflow-y-scroll h-screen
                            md:pl-16
                            lg:px-56">
    <section class="flex overflow-clip overflow-y-auto scrollbar-hide" id="content">

        <section id="timeline" class="flex flex-col w-screen max-h-min overflow-clip" data-page="0">
            <!-- Javascript will render posts here -->
            <div id="fetcher" class="h-16"></div>
        </section>
    </section>
    <div id="dark-overlay" class="hidden fixed top-0 left-0 w-full h-full bg-black z-10" style="opacity: 0.8;"></div>

    @auth
    <!--<div id="create-post" class="relative z-20">
        @include('partials.create_post_form', [
        'formClass' => 'add-post w-full md:w-2/3 lg:w-1/2 xl:w-1/3 hidden fixed bottom-1/2 left-1/2 transform
        -translate-x-1/2 bg-gray-200 rounded px-10 py-5',
        'textPlaceholder' => 'Add a new post', 'buttonText' => 'Create Post', 'contentValue' => ''])
        <button class="add-post-on rounded px-4 py-2 fixed bottom-5 right-20">Add Post</button>
        <button class="add-post-off hidden bg-gray-200 rounded px-4 py-2 fixed bottom-5 right-20">Cancel</button>
    </div>-->
    @endauth
</main>
@endsection