@extends('layouts.app')

@section('title', 'Network')

@section('content')
@include('partials.network.network_page', [
    'user' => $user
])
@endsection