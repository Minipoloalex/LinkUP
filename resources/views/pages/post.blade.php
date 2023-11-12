@extends('layouts.app')

@section('title', 'Post')

@section('content')
    @include('partials.post', ['post' => $post, 'displayComments' => true])
@endsection
