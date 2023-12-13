@extends('layouts.admin')

@section('content')
<div class="flex mt-4 content-center justify-center items-center w-full mx-auto">
    @include('partials.post', ['post' => $post, 'displayComments' => true, 'showAddComment' => false, 'showEdit' => false, 'isAdmin' => true])
</div>
@endsection
