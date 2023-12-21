@extends('layouts.app')

@section('title', 'Post')

@section('content')
<main id="postpage" class=" flex flex-col w-screen overflow-clip overflow-y-scroll h-[calc(100vh-6rem)] scrollbar-hide 
                            lg:w-full">
    <section class="flex overflow-clip overflow-y-scroll scrollbar-hide h-full" id="content">
        <section id="post-section" class="flex flex-col w-screen h-full">
            @if ($parent)
            <div id="parent-post" class="w-full py-2 hidden">
                @include('partials.post', ['post' => $parent, 'displayComments' => false, 'showAddComment' => false,
                'showEdit'=> false])
            </div>
            <div id="arrow-up" class="flex items-center justify-center w-full">
                <div class="flex items-center justify-center w-10 h-10">
                    <i class="fas fa-arrow-up"></i>
                </div>
            </div>
            @endif

            @include('partials.post', ['post' => $post, 'displayComments' => true, 'showAddComment' => true,
            'showEdit'=> true])
        </section>

        <!-- filler div -->
        <div class="h-[1500px]"></div>

    </section>
</main>

<script type="module" src="{{ asset('js/posts/post.js') }}"></script>

@endsection