@extends('layouts.app')

@section('title', 'Post')

@section('content')
<main id="postpage" class="grid grid-cols-4 absolute top-32 left-0 w-screen px-64">
    @include('partials.side.navbar')
    <section class="col-span-2 flex flex-grow pt-16 overflow-y-auto scrollbar-hide" id="content">    
        @include('partials.post', ['post' => $post, 'displayComments' => true, 'showEdit' => True])
    </section>
    @include('partials.side.notifications-tab')
</main>
@endsection
