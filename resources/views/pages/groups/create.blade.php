@extends('layouts.app')

@section('title', 'Create Group')

@section('content')

<main id="group-page" class="flex flex-col w-screen overflow-clip overflow-y-scroll h-screen pt-24
                            md:pl-16
                            lg:px-56">

    @include('partials.side.navbar')
        
    <section id="group" class="w-full mt-24">
        <div class="flex flex-col w-full mb-16">
            <h1 class="text-4xl font-bold">Create Group</h1>
        </div>

        <div class="flex flex-col mt-8">
            <form action="{{ route('group.create') }}" method="POST" class="w-1/2">
                @csrf

                <div>
                    <label for="name" class="text-xl font-bold">Name</label>
                    <input type="text" name="name" id="name" class="border-2 border-gray-300 rounded-lg" required>
                </div>

                <div class="flex flex-col mt-4">
                    <label for="description" class="text-xl font-bold mb-2">Description</label>
                    <textarea name="description" id="description" cols="5" rows="5" class="border-2 border-gray-300 rounded-lg"></textarea>
                </div>

                <div class="mt-4">
                    <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-lg">
                        <i class="fas fa-plus mr-1"></i>
                        Create
                    </button>
                </div>
            </form>
        </div>
    </section>
</main>
