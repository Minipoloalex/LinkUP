@extends('layouts.admin')

@section('content')
<div class="flex flex-col mt-4 content-center justify-center items-center w-full mx-auto gap-4">
    @include('partials.header.search-bar', ['placeholder' => 'Search users...'])
    <table class="w-full border border-dark-neutral px-4 py-2">
        <thead class="text-xl text-left">
            <tr class="border-b">
                <th class="w-12 px-2 py-1">Id</th>
                <th>Username</th>
                <th>Name</th>
                <th>Email</th>
                <th></th>
            </tr>
        </thead>
        <tbody id="container-admin-users" data-page="0"></tbody>
    </table>
    <div id="fetcher-admin-users"></div>
</div>


@endsection