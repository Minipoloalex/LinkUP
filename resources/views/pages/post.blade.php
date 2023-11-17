@extends('layouts.app')

@section('title', 'Post')

@section('content')
    @include('partials.post', ['post' => $post, 'displayComments' => true])
    <button class="toggle-add-post">Add Post</button>
    @include('partials.create_post_form', ['type' => 'post'])
@endsection
