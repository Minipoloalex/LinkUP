@extends('layouts.app')
@section('title', $group->name)

@section('content')

@include('partials.group.group_page', [
    'group' => $group,
    'isAdmin' => false,
    'user_is_owner' => $user_is_owner,
    'user_is_member' => $user_is_member,
    'user_is_pending' => $user_is_pending,
])
@endsection