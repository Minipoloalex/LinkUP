@extends('layouts.app')

@section('title', 'About')

@section('content')
<main id="aboutUs" class="grid grid-cols-4 absolute top-32 left-0 w-screen px-64">
    @include('partials.side.navbar')
    <section class="col-span-2 flex flex-col flex-grow pt-16 overflow-y-auto scrollbar-hide" id="content">
        
        <div class="flex flex-col items-center justify-center w-full h-full px-2">
            <h1 class="text-4xl font-bold text-center">Meet the Team</h1>
            <p class="text-center"> We are a group of students from FEUP, Portugal. We are currently enrolled in the course of LEIC</p>
        </div>

        <!-- create Contact Form here -->
        <!-- like a report form -->
        @include('partials.about_us_members')

        <div class="flex justify-center mt-4">
            <a href="{{ url('/contact') }}" class="bg-gray-300 hover:bg-gray-400 text-black font-bold py-2 px-4 rounded-full">Contact Us</a>
        </div>

        
    </section>
    @include('partials.side.notifications-tab')
    <div id="dark-overlay" class="hidden fixed top-0 left-0 w-full h-full bg-black" style="opacity: 0.8;"></div>

    
</main>
@endsection