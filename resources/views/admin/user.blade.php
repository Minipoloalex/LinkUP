@extends('layouts.admin')

@push('scripts')
<script type="module" src="{{ url('js/profile/profile_infinite_scrolling.js') }}"></script>
@endpush

@section('title', "Profile $user->username")  {{-- this is protected from XSS --}}

@section('content')
@include('partials.profile.profile_page', [
    'user' => $user,
    'userCanSeePosts' => true   // admin
])
@endsection
