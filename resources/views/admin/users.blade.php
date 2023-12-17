@extends('layouts.admin')

@section('content')
<div class="flex flex-col mt-4 content-center justify-center items-center w-full mx-auto">
    @include('partials.header.search-bar', ['placeholder' => 'Search users...'])
    <table class="w-2/3 border border-slate-300">
        <thead class="text-xl text-left">
            <tr>
                <th class="w-12">Id</th>
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