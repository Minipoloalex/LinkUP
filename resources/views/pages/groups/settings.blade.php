@extends('layouts.app')
@include('partials.side.navbar')

@section('content')
<main id="group-page" class="flex flex-col w-screen overflow-clip overflow-y-scroll h-screen pt-24
                            md:pl-16
                            lg:px-56">

    <section class="flex flex-col w-full border border-slate-400">
        <div class="flex flex-col items-center justify-start h-72 w-full">
            <div class="flex justify-start items-center w-full pl-12 mt-6">
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
                <input type="name" id="group-name" value="{{ $group->name }}"
                    class="text-lg border-b border-slate-400 ml-8">
            </div>
            <div class="flex justify-start items-center w-full pl-36">
                <textarea name="description" id="group-description" cols="35" rows="5"
                    class="text-base border border-slate-400 resize-none p-2">{{ $group->description }}</textarea>
            </div>
        </div>
    </section>
    <section class="flex flex-col w-full border border-slate-400">
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
    </section>
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
    </section>
</main>

<input type="hidden" id="group-id" value="{{ $group->id }}">
<script type="module" src="{{ url('js/group/settings.js') }}"></script>
@endsection