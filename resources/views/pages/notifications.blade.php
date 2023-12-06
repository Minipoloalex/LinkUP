@extends('layouts.app')
@section('title', 'Home')
@section('content')

@include('partials.side.navbar')

<main id="homepage" class=" flex flex-col w-full overflow-hidden overflow-y-scroll h-screen pt-36 scrollbar-hide
                            md:pl-16
                            lg:px-56">

    <h1 class="text-3xl font-bold text-center">Notifications</h1>
    <section class="flex flex-col w-full">
        @foreach ($notifications as $notification)
        @include ('partials.notifications.notification')
        @endforeach
    </section>
</main>
@endsection