@extends('layouts.app')

@section('title', 'Contact')

@section('content')
<main id="contactUs" class="flex flex-col w-screen overflow-clip overflow-y-scroll h-[calc(100vh-6rem)] scrollbar-hide
                            lg:w-full">
    <section class="col-span-2 flex flex-col flex-grow pt-16 overflow-y-auto scrollbar-hide" id="content">
        <div class="flex flex-col items-center justify-center w-full h-full px-2">
            <h1 class="text-4xl font-bold text-center">Contact Us</h1>
            <p class="text-center">We are here to help and answer any question you might have. We look forward to
                hearing from you.</p>
        </div>
        <!-- create Contact Form here -->
        <!-- like a report form -->
        @include('partials.contact_form')
    </section>
    <div id="dark-overlay" class="hidden fixed top-0 left-0 w-full h-full bg-black" style="opacity: 0.8;"></div>


</main>
@endsection