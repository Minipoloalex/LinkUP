@extends('layouts.admin')

@section('content')
@include('partials.header.search-bar', ['placeholder' => 'Search users...'])
<div id="container-admin-posts" data-page="0"></div>
<div id="fetcher-admin-posts"></div>

{{-- {{ $posts->links() }} --}}

@endsection