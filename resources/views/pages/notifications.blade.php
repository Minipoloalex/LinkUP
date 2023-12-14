@extends('layouts.app')
@section('title', 'Home')
@section('content')

@include('partials.side.navbar')

<main id="homepage" class=" flex flex-col w-screen overflow-clip overflow-y-scroll h-[calc(100vh-10rem)] scrollbar-hide
                            lg:w-full">

    <h1 class="text-3xl font-bold text-center">Notifications</h1>
    <section class="flex flex-col w-full">
        @foreach ($notifications as $notification)
        @include ('partials.notifications.notification')
        @endforeach
    </section>
</main>
@endsection