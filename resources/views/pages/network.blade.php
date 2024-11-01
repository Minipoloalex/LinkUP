@php
$activePage = 'network';
@endphp
@extends('layouts.app')

@section('title', 'Network')

@push('scripts')
<script type="module" src="{{ url('js/network.js') }}"></script>
@endpush

@section('content')
@include('partials.network.network_page', [
'user' => $user
])
@endsection