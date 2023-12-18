@extends('layouts.app')

@section('title', 'Create Group')

@section('content')
<main id="group-page" class="flex flex-col w-screen overflow-clip overflow-y-scroll h-[calc(100vh-10rem)] scrollbar-hide
                            lg:w-full">

    <section id="group" class="w-full p-4 flex flex-col gap-4">
        <div class="flex flex-col w-full">
            <h1 class="text-2xl font-bold">Create Group</h1>
        </div>

        <div class="flex flex-col">
            <form action="{{ route('group.create') }}" method="POST" class="flex flex-col gap-4 w-full">
                @csrf

                <div class="relative w-full">
                    <input id="name" name="name" type="text" required class="peer h-10 w-full
                                dark:bg-dark-primary border-b-2 dark:border-dark-secondary dark:text-dark-secondary 
                                text-sm placeholder-transparent focus:outline-none dark:focus:border-dark-active"
                        placeholder="name" />
                    <label for="name" class=" absolute left-0 -top-3.5 transition-all peer-placeholder-shown:text-xl
                                            dark:peer-placeholder-shown:text-dark-secondary peer-placeholder-shown:top-2 peer-focus:-top-3.5 
                                            dark:peer-focus:text-dark-active peer-focus:text-base">
                        Name
                    </label>
                </div>

                <div class="flex flex-col mt-4 group">
                    <label for="description"
                        class="text-xl mb-2 group-focus-within:dark:text-dark-active">Description</label>
                    <textarea name="description" id="description" cols="5" rows="5"
                        class="border dark:bg-dark-primary dark:border-dark-neutral rounded resize-none p-2"></textarea>
                </div>

                <div class="flex items-center justify-end">
                    <button type="submit" class="dark:bg-dark-active dark:text-dark-secondary py-2 px-4 rounded-lg">
                        Create
                    </button>
                </div>
            </form>
        </div>
    </section>
</main>
@endsection