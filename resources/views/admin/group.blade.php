@extends('layouts.admin')
@section('title', 'Group {{$group->name}}')

@push('scripts')
<script type="module" src="{{ url('js/group/group.js')}}"></script>
@endpush

@section('content')
@include('partials.group.group_page', [
    'group' => $group,
    'isAdmin' => true,
    'user_is_owner' => false,
    'user_is_member' => false,
    'user_is_pending' => false,
])
@endsection
