@php
$activePage = 'about';
@endphp
@extends('layouts.app')
@section('title', 'About')
@section('content')
<main id="about" class="  flex flex-col w-screen overflow-clip overflow-y-scroll h-[calc(100vh-6rem)] scrollbar-hide
                            lg:w-full">

    <header class="mx-12 mt-12 mb-8">
        <h1 class="text-4xl font-bold">About</h1>
    </header>

    <section id="vision" class="flex flex-col mx-12 mb-8 space-y-4">
        <h2 class="text-2xl font-bold">Our Vision</h2>
        <p class="text-sm">
            LINK UP is an innovative social network designed exclusively for the students of the University of Porto.
        </p>
        <p class="text-sm">
            The motivation behind the project is to make a positive impact on the university ecosystem.
            LINK UP aims to strengthen the sense of community within the institution by providing a dedicated platform
            for students and staff to connect.
        </p>
    </section>

    <section id="team" class="flex flex-col mx-12 mb-8 space-y-4">
        <h2 class="text-2xl font-bold">Our Team</h2>
        <p class="text-sm">
            LINK UP is currently being developed by a small team of students from FEUP.
        </p>
        <div class="grid grid-cols-4 gap-4 lg:px-8 pt-8">
            <div class="flex flex-col items-center">
                <img class="w-16 h-16 lg:w-32 lg:h-32 rounded-full" src="{{ asset('images/team/domingos.jpg') }}"
                    alt="Bruno">
                <p class="text-sm font-bold mt-4 mb-1">Domingos Santos</p>
                <p class="text-sm">Developer</p>
            </div>
            <div class="flex flex-col items-center">
                <img class="w-16 h-16 lg:w-32 lg:h-32 rounded-full" src="{{ asset('images/team/duarte.jpg') }}"
                    alt="Bruno">
                <p class="text-sm font-bold mt-4 mb-1">Duarte Gonçalves</p>
                <p class="text-sm">Developer</p>
            </div>
            <div class="flex flex-col items-center">
                <img class="w-16 h-16 lg:w-32 lg:h-32 rounded-full" src="{{ asset('images/team/felix.jpg') }}"
                    alt="Bruno">
                <p class="text-sm font-bold mt-4 mb-1">Félix Martins</p>
                <p class="text-sm">Developer</p>
            </div>
            <div class="flex flex-col items-center">
                <img class="w-16 h-16 lg:w-32 lg:h-32 rounded-full" src="{{ asset('images/team/marco.jpg') }}"
                    alt="Bruno">
                <p class="text-sm font-bold mt-4 mb-1">Marco Vilas Boas</p>
                <p class="text-sm">Developer</p>
                <p class="text-sm">SCRUM Master</p>
            </div>
        </div>
    </section>

    <section id="contacts" class="flex flex-col mx-12 space-y-4">
        <h2 class="text-2xl font-bold">Contacts</h2>
        <p class="text-sm">
            For any support related questions, please feel free to contact us at
            <a class="text-blue-500 hover:underline" href="mailto:support@linkup.com">
                support@linkup.com
            </a>
        </p>
        <p class="text-sm">
            If you have any feedback or suggestions, please let us know at
            <a class="text-blue-500 hover:underline" href="mailto:feedback@linkup.com">
                feedback@linkup.com
            </a>
        </p>
    </section>
</main>
@endsection