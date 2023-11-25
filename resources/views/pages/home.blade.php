@extends('layouts.app')

@section('title', 'Home')

@section('content')
<main id="homepage" class="grid grid-cols-4 absolute top-32 left-0 w-screen px-64">
    @include('partials.side.navbar')
    <section class="col-span-2 flex flex-grow pt-16 overflow-y-auto scrollbar-hide" id="content">
        <section id="timeline" class="flex flex-col flex-grow w-max max-h-min">
            <!-- Javascript will render posts here -->
            <div id="fetcher">
                <p class="text-center">Loading...</p>
            </div>
        </section>
    </section>
    @include('partials.side.notifications-tab')
    <div id="dark-overlay" class="hidden fixed top-0 left-0 w-full h-full bg-black" style="opacity: 0.8;"></div>

    @auth
        <div id="create-post" class="relative">
            @include('partials.create_post_form', [
            'formClass' => 'add-post w-full md:w-2/3 lg:w-1/2 xl:w-1/3 hidden fixed bottom-1/2 left-1/2 transform
            -translate-x-1/2 bg-gray-200 rounded px-10 py-5',
            'textPlaceholder' => 'Add a new post', 'buttonText' => 'Create Post', 'contentValue' => ''])
            <button class="add-post-on rounded px-4 py-2 fixed bottom-5 right-20">Add Post</button>
            <button class="add-post-off hidden bg-gray-200 rounded px-4 py-2 fixed bottom-5 right-20">Cancel</button>
        </div>
    @endauth
</main>
@endsection
