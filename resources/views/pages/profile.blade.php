<!-- resources/views/user/profile.blade.php -->

@extends('layouts.app')

@section('title', 'profile-page')

@section('content')
    <h2>{{ $user->name }}'s Profile</h2>
    <!-- Add other user information here -->
@endsection
