@extends('layouts.admin')

@section('content')
<div class="w-full flex items-center justify-center mb-4">
    <div class="flex content-center flex-wrap justify-center w-3/4 px-2 pb-8 mt-2">
        <div class="flex content-center justify-center w-full">
            <form id="search-form"
                class="self-center flex content-center justify-center py-1 rounded-full group"
                action="{{ url('/search') }}" method="GET">
                <div
                    class="rounded-full bg-transparent h-10 flex items-center justify-center border-2 border-dark-active">
                    <i class="fas fa-search text-white ml-3"></i>
                    <input id="search-text" class="align-middle w-full bg-transparent ml-2 mr-3 text-white font-normal text-sm
                    focus:outline-none" type="text" name="query" placeholder="Search Posts" autocomplete="off">
                </div>
            </form>
        </div>
    </div>
</div>

<div id="container-admin-posts" class="w-full border border-dark-neutral" data-page="0"></div>
<div id="fetcher-admin-posts"></div>

@endsection