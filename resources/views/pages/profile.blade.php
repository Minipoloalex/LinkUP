@php
$userCanSeePosts = $user->is_private === false || (Auth::check() && ($user->id === Auth::user()->id ||
Auth::user()->isFollowing($user)));
@endphp

@extends('layouts.app')
@section('title', "Profile $user->username")

@section('content')
@include('partials.profile.profile_page', [
    'user' => $user,
    'userCanSeePosts' => $userCanSeePosts
])
@endsection