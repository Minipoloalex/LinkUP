@php
$activePage = 'notifications';
@endphp
@extends('layouts.app')
@section('title', 'Home')

@push('scripts')
<script type="module" src="{{ url('js/notifications/notifications.js') }}"></script>
@endpush

@section('content')
<h1 class="sticky top-24 left-0 bg-dark-primary flex h-12 border-b-2 dark:border-dark-active items-center justify-center">
    <p class="font-bold text-dark-active">Notifications</p>
    <span class="ml-2 text-xs text-gray-500 dark:text-dark-secondary">{{ $notifications->where('seen', false)->count() }} new</span>
</h1>

<main id="homepage" class=" flex flex-col w-screen overflow-clip overflow-y-scroll h-[calc(100vh-10rem)] scrollbar-hide
                            lg:w-full">
    <section class="flex flex-col w-full" id="notifications-home-container">
        <div id="notifications-home-fetcher" class="filler h-16 lg:h-0"></div>
    </section>
</main>
@endsection