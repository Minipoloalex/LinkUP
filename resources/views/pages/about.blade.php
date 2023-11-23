@extends('layouts.app')

@section('title', 'About')

@section('content')
<main id="aboutuspage" class="grid grid-cols-4 absolute top-32 left-0 w-screen px-64">
    @include('partials.side.navbar')
    <section class="col-span-2 flex flex-grow pt-16 overflow-y-auto scrollbar-hide" id="content">
        <section class="mb-8">
            <h2 class="text-2xl font-bold mb-4">Our Mission</h2>
            <p class="text-gray-700">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>
        </section>

        <section class="mb-8">
            <h2 class="text-2xl font-bold mb-4">Our Team</h2>
            <p class="text-gray-700">Meet the passionate individuals who make our team strong and dedicated to our mission.</p>
        </section>

        <section>
            <h2 class="text-2xl font-bold mb-4">Contact Us</h2>
            <p class="text-gray-700">Feel free to reach out to us if you have any questions or inquiries.</p>
            <p class="text-gray-700">Email: info@example.com</p>
            <p class="text-gray-700">Phone: (123) 456-7890</p>
        </section>
    </section>
    @include('partials.side.notifications-tab')
    <div id="dark-overlay" class="hidden fixed top-0 left-0 w-full h-full bg-black" style="opacity: 0.8;"></div>

    
</main>
@endsection