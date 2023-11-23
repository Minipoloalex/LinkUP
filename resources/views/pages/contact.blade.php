@extends('layouts.app')

@section('title', 'Contact')

@section('content')
<main id="aboutuspage" class="grid grid-cols-4 absolute top-32 left-0 w-screen px-64">
    @include('partials.side.navbar')
    <section class="col-span-2 flex flex-grow pt-16 overflow-y-auto scrollbar-hide" id="content">
        

        <!-- create Contact Form here -->
        <!-- like a report form -->

        
    </section>
    @include('partials.side.notifications-tab')
    <div id="dark-overlay" class="hidden fixed top-0 left-0 w-full h-full bg-black" style="opacity: 0.8;"></div>

    
</main>
@endsection