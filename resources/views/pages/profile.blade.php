@php
$userCanSeePosts = $user->is_private === false || (Auth::check() && ($user->id === Auth::user()->id ||
Auth::user()->isFollowing($user)));
@endphp

@push('scripts')
<script type="module" src="{{ url('js/profile/profile_infinite_scrolling.js') }}"></script>
@endpush

@extends('layouts.app')
@section('title', "Profile $user->username")

@section('content')
@include('partials.profile.profile_page', [
'user' => $user,
'userCanSeePosts' => $userCanSeePosts
])
@endsection