@extends('layouts.admin')

@section('content')
@foreach($posts as $post)

@include('partials.post', ['post' => $post, 'displayComments' => false, 'showAddComment' => false, 'showEdit' => false])

@endforeach
@endsection