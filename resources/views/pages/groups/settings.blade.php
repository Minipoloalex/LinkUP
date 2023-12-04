@extends('layouts.app')
@include('partials.side.navbar')

@section('content')
<main id="group-page" class="flex flex-col w-screen overflow-clip overflow-y-scroll h-screen pt-24
                            md:pl-16
                            lg:px-56">

    <section class="flex flex-col w-full border border-slate-400">
        <div class="w-full">
            <h1 class="text-xl text-bold ml-12 mt-4"> Edit Group </h1>
            <form action="{{ route('group.update', ['id' => $group->id]) }}" method="POST" enctype="multipart/form-data"
                class="flex items-center justify-start w-full pt-4 px-12 h-60">
                @csrf
                @method('PUT')
                <div class="flex justify-start items-start h-full">
                    <div class="relative top-0 left-0" id="change-group-photo">
                        <label for="group-photo-input" class="cursor-pointer">
                            <img src="{{ url('images/groups/icons/' . $group->id . '.jpg') }}" alt="group photo"
                                class="w-16 h-16 rounded-full" id="group-photo-img">
                            <div class="absolute top-0 left-0 w-16 h-16 rounded-full bg-black bg-opacity-50 flex items-center justify-center hidden"
                                id="group-photo-hover">
                                <i class="fas fa-camera text-white"></i>
                            </div>
                        </label>
                        <input type="file" id="group-photo-input" class="hidden">
                    </div>
                </div>
                <div class="flex flex-col justify-start items-center w-5/6 h-full">
                    <input name="name" id="group-name" value="{{ $group->name }}"
                        class="text-lg border-b border-slate-400 w-full my-2 ml-8 px-2">
                    <textarea name="description" id="group-description"
                        class="text-base border border-slate-400 resize-none w-full ml-8 grow px-2">{{ $group->description }}</textarea>
                    <div class="flex justify-end items-center w-full ml-8 mt-2">
                        @include('partials.components.button', ['id' => 'update-group', 'icon' => 'fas fa-save', 'color'
                        =>
                        'green', 'text' => 'Update'])
                    </div>
                </div>
            </form>
        </div>
    </section>

    <section class="flex flex-col border border-slate-400 mt-4">
        <h1 class="text-xl text-bold ml-12 mt-4">Change Ownership</h1>
    </section>

    <section class="flex flex-col border border-slate-400 mt-4" id="group-content">
        <h1 class="text-xl text-bold ml-12 mt-4">Delete Group</h1>
        <div class="flex justify-start items-center w-full py-2 pl-12">
            @include('partials.components.button', ['id' => 'delete-group', 'icon' => 'fas fa-trash-alt', 'color'
            =>
            'red', 'text' => 'Delete'])
        </div>
    </section>
</main>

<input type="hidden" id="group-id" value="{{ $group->id }}">
<script type="module" src="{{ url('js/group/settings.js') }}"></script>
@endsection