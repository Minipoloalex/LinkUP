@extends('layouts.admin')

@section('content')
<div class="flex flex-col mt-4 content-center justify-center items-center w-full mx-auto gap-4">
<div class="flex content-center flex-wrap justify-center w-3/4 px-2 pb-8 mt-2">
    <div class="flex content-center justify-center w-full">
        <form id="search-form"
            class="self-center flex content-center justify-center py-1 rounded-full group"
            action="{{ url('/search') }}" method="GET">
            <div
                class="rounded-full bg-transparent h-10 flex items-center justify-center border-2 border-dark-active">
                <i class="fas fa-search text-white ml-3"></i>
                <input id="search-text" class="align-middle w-full bg-transparent ml-2 mr-3 text-white font-normal text-sm
                focus:outline-none" type="text" name="query" placeholder="Search Users" autocomplete="off">
            </div>
        </form>
    </div>
</div>
    <table class="w-full px-4 py-2">
        <thead class="text-xl text-left">
            <tr class="border-2 border-dark-active">
                <th class="w-12 px-2 py-1">ID</th>
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