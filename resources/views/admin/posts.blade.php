@extends('layouts.admin')

@section('content')

@foreach($posts as $post)

@include('partials.post', ['post' => $post, 'displayComments' => false, 'showEdit' => false])
    
@endforeach

{{ $posts->links() }}

@endsection