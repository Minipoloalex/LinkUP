@extends('layouts.app')

@section('title', 'Home')

@section('content')
    <main id="homepage" class="grid grid-cols-4 absolute top-32 left-0 w-screen px-64">
        @include('partials.side.left-tab')
        <section class="col-span-2 flex flex-grow pt-16 overflow-y-auto scrollbar-hide" id="content">
            <section id="timeline" class="flex flex-col flex-grow w-max max-h-min">
                <!-- Javascript will render posts here -->
                <div id="fetcher">
                    <p class="text-center">Loading...</p>
                </div>
            </section>
        </section>
        @include('partials.side.right-tab')
        <div id="create-post">
            @include('partials.create_post_form', ['formClass' => 'add-post hidden', 'textPlaceholder' => 'Add a new post', 'buttonText' => 'Create Post', 'contentValue' => ''])
            <button class="add-post-on">Add Post</button>
            <button class="hidden add-post-off">Clear</button>
        </div>
    </main>
@endsection
