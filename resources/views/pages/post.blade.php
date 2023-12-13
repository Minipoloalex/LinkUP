@extends('layouts.app')

@section('title', 'Post')

@section('content')
<main id="postpage" class=" flex flex-col w-screen overflow-clip overflow-y-scroll h-[calc(100vh-6rem)] scrollbar-hide
                            lg:w-full">
    <section class="flex overflow-clip overflow-y-auto scrollbar-hide" id="content">
        <section id="post-section" class="flex flex-col w-screen max-h-min">
            @include('partials.post', ['post' => $post, 'displayComments' => true, 'showAddComment' => true, 'showEdit'
            => true])
        </section>
    </section>
</main>
@endsection