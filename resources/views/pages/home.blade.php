@extends('layouts.app')
@section('title', 'Home')

@push('scripts')
<script type="module" src="{{ url('js/home/home.js') }}"></script>
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
</main>

@auth
<div id="create-post"
    class="hidden fixed top-0 left-0 w-screen h-screen bg-transparent z-20 lg:px-[10vw] xl:px-[30vw] pointer-events-none">
    <div class="h-[6rem] w-full filler"></div>
    @include('partials.create_post_form', [
    'formClass' => '',
    'textPlaceholder' => 'Add a new post', 'buttonText' => 'Post', 'contentValue' => ''])
</div>
@endauth
<div id="dark-overlay" class="hidden fixed top-0 left-0 w-full h-full bg-black opacity-40 z-10"></div>
@endsection