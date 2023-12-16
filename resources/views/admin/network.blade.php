@extends('layouts.admin')

@section('title', 'Network')
@push('scripts')
<script type="module" src="{{ url('js/network.js')}}"></script>
@endpush

@section('content')
@include('partials.network.network_page', [
    'user' => $user
])
@endsection