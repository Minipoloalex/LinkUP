@extends('layouts.admin')

@section('content')
<div class="w-full flex items-center justify-center mb-4">
    @include('partials.header.search-bar', ['placeholder' => 'Search users...'])
</div>

<div id="container-admin-posts" class="w-full border border-dark-neutral" data-page="0"></div>
<div id="fetcher-admin-posts"></div>

@endsection