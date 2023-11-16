@extends('layouts.app')

@section('title', 'Post')

@section('content')
    @include('partials.post', ['post' => $post, 'displayComments' => false])
    <button class="toggle-add-post">Add Post</button>
    <form class="add-post">
        <input type="text" name="content" placeholder="Add a post" value="">
    </form>
@endsection
