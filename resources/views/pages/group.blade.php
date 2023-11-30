@php
$type = $user_is_owner ? 'owner' : ($user_is_member ? 'member' : ($user_is_pending ? 'pending' : 'none'));
@endphp

@extends('layouts.app')
@section('content')
@include('partials.side.navbar')


<main id="group-page" class=" flex flex-col w-screen overflow-clip overflow-y-scroll h-screen pt-24
                            md:pl-16
                            lg:px-56">
    <section class="flex flex-col border border-slate-400 mt-1" id="group-content">
        <div class="flex flex-col items-center justify-center h-56 w-full">
            <div class="flex justify-start items-center w-full pl-12">
                <img src="{{ url('images/groups/icons/' . $group->id . '.jpg') }}" alt="group photo"
                    class="w-16 h-16 rounded-full">
                <h1 class="text-2xl font-bold pl-8">{{ $group->name }}</h1>
            </div>
            <div class="flex justify-start items-center w-full pl-36">
                <p class="text-lg">{{ $group->description }}</p>
            </div>
        </div>
        <div class="h-16 flex w-full items-end justify-end py-6 px-10">
            @include('partials.group.button', ['type' => $type])
        </div>
    </section>

    @if($user_is_member)

    <div class="flex w-full items-center">
        <div id="posts" class="flex items-center justify-center w-1/2 h-10 border border-slate-400">
            <h1>Posts</h1>
        </div>
        <div id="members" class="flex items-center justify-center w-1/2 h-10 border border-slate-400">
            <h1>Members</h1>
        </div>
    </div>

    <section id="posts-section" class="flex flex-col items-center">
        @foreach ($posts as $post)
        @include('partials.post', ['post' => $post, 'displayComments' => true, 'showEdit' => false])
        @endforeach
    </section>

    <section id="members-section" class="flex flex-col items-center hidden">
        @foreach ($members as $member)
        @include('partials.group.member', ['member' => $member])
        @endforeach
    </section>

    @else

    <section class="flex flex-col w-full items-center justify-center p-4 pt-16">
        <h2 class="text-lg">Seems that you are not a member yet...</h2>
        <h2 class="text-lg">Ask to join!</h2>
    </section>

    @endif


    <div id="dark-overlay" class="hidden fixed top-0 left-0 w-full h-full bg-black z-10" style="opacity: 0.8;"></div>

    @if(Auth::check())
    <div id="create-post" class="relative z-20">
        @include('partials.create_post_form', [
        'formClass' => 'add-post w-full md:w-2/3 lg:w-1/2 xl:w-1/3 hidden fixed bottom-1/2 left-1/2 transform
        -translate-x-1/2 bg-gray-200 rounded px-10 py-5',
        'textPlaceholder' => 'Add a new post', 'buttonText' => 'Create Post', 'contentValue' => ''])
        <button class="add-post-on rounded px-4 py-2 fixed bottom-5 right-20">Add Post</button>
        <button class="add-post-off hidden bg-gray-200 rounded px-4 py-2 fixed bottom-5 right-20">Cancel</button>
    </div>
    @endif
</main>

<script type="module" src="{{ url('js/group/group.js') }}"></script>
@endsection