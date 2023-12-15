@extends('layouts.admin')

@section('content')
<div class="flex flex-col mt-4 content-center justify-center items-center w-full mx-auto">
    @include('partials.header.search-bar', ['placeholder' => 'Search groups...'])
    <table class="w-2/3 border border-slate-300">
        <thead class="text-xl text-left">
            <tr>
                <th>Group Id</th>
                <th>Name</th>
                <th>Owner</th>
                <th>Members</th>
                <th></th>
            </tr>
        </thead>

        <tbody id="container-admin-groups" data-page="0"></tbody>
    </table>
    <div id="fetcher-admin-groups"></div>
</div>

@endsection