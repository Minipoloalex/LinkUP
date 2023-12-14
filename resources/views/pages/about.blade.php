@extends('layouts.app')
@section('title', 'About')
@section('content')
<main id="aboutUs" class="  flex flex-col w-screen overflow-clip overflow-y-scroll h-[calc(100vh-6rem)] scrollbar-hide
                            lg:w-full">

    <section class="flex flex-col flex-grow px-6 pt-12 items-center space-y-4" id="content">
        <div class="flex flex-col items-center justify-center w-2/3 px-2 mb-4 space-y-4">
            <h1 class="text-4xl font-bold text-center">Meet the Team</h1>
            <p class="text-center">
                We are a group of students from FEUP, Portugal.
            </p>
        </div>

        @include('partials.about_us_members')

        <!-- <div class="flex justify-center mt-4">
            <a href="{{ url('/contact') }}"
                class="bg-gray-300 hover:bg-gray-400 text-black font-bold py-2 px-4 rounded-full">Contact Us</a>
        </div> -->
        <div class="filler h-16"></div>
    </section>
    <div id="dark-overlay" class="hidden fixed top-0 left-0 w-full h-full bg-black" style="opacity: 0.8;"></div>
</main>
@endsection