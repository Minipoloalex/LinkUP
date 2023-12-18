@extends('layouts.app')
@section('title', 'Home')

@push('scripts')
<script type="module" src="{{ url('js/notifications/notifications.js') }}"></script>
@endpush

@section('content')
<main id="homepage" class=" flex flex-col w-screen overflow-clip overflow-y-scroll h-[calc(100vh-10rem)] scrollbar-hide
                            lg:w-full">

    <h1 class="text-xl py-1 border-b dark:border-dark-neutral font-bold text-center">Notifications</h1>
    <section class="flex flex-col w-full" id="notifications-home-container">
        <div id="notifications-home-fetcher" class="filler h-16 lg:h-0"></div>
    </section>
</main>
@endsection