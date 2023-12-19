@php
$activePage = 'profile';
$userCanSeePosts = $user->is_private === false || (Auth::check() && ($user->id === Auth::user()->id ||
Auth::user()->isFollowing($user)));
@endphp

@extends('layouts.app')
@section('title', "Profile $user->username")

@push('scripts')
<script type="module" src="{{ url('js/profile/profile_infinite_scrolling.js') }}"></script>
@endpush

@section('content')
@include('partials.profile.profile_page', [
'user' => $user,
'userCanSeePosts' => $userCanSeePosts,
'followRequest' => $followRequest
])
@endsection