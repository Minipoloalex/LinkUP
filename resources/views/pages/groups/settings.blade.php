@extends('layouts.app')
@section('title', 'Group Settings')


@section('content')

<main id="group-page" class="flex flex-col w-screen h-screen
                            lg:pl-16
                            xl:px-56">

    <section class="flex flex-col w-full">
        <div class="w-full">
            <h1 class="text-xl text-bold ml-12 mt-4"> Edit Group </h1>
            <form action="{{ route('group.update', ['id' => $group->id]) }}" method="POST" enctype="multipart/form-data"
                class="flex items-center justify-start w-full pt-4 px-12 h-60">
                @csrf
                @method('PUT')
                <div class="flex justify-start items-start h-full">
                    <div class="file-input-wrapper relative top-0 left-0" id="change-group-photo">
                        <label for="group-photo-input" class="cursor-pointer">
                            <img src="{{ $group->getPicture() }}" alt="group photo"
                                class="image-preview w-16 h-16 rounded-full">
                            {{-- <div class="rounded-full p-1 absolute -top-1 -right-1 bg-black">
                                <i class="fas fa-pencil-alt text-white"></i>
                            </div> --}}
                            <div class="absolute top-0 left-0 w-16 h-16 rounded-full bg-black bg-opacity-50 flex items-center justify-center hidden"
                                id="group-photo-hover">
                                <i class="fas fa-camera text-white"></i>
                            </div>
                            <div class="text-center">Edit</div>
                        </label>
                        <input type="file" id="group-photo-input" class="hidden" name="image" accept="image/*">
                        @include('partials.images_crop_input')
                    </div>
                </div>
                <div class="flex flex-col justify-start items-center w-5/6 h-full">
                    <input name="name" id="group-name" value="{{ $group->name }}"
                        class="text-lg dark:bg-dark-primary w-full my-2 ml-8 px-2">
                    <textarea name="description" id="group-description"
                        class="text-base dark:bg-dark-primary resize-none w-full ml-8 grow px-2">{{ $group->description }}</textarea>
                    <div class="flex justify-end items-center w-full ml-8 mt-2">
                        @include('partials.components.button', ['id' => 'update-group', 'icon' => 'fas fa-save', 'color'
                        =>
                        'green', 'text' => 'Update'])
                    </div>
                </div>
            </form>
        </div>
    </section>

    <section class="flex flex-col mt-4">
        <div class="w-full">
            <h1 class="text-xl text-bold ml-12 mt-4"> Change Ownership </h1>
            <form id="change-owner-form" action="{{ route('group.changeOwner', ['id' => $group->id]) }}" method="POST"
                class="flex items-center justify-start w-full pt-4 px-12 h-60">
                @csrf
                @method('POST')
                <div class="flex flex-col justify-start items-center w-5/6 h-full">
                    <select name="new_owner" id="new-owner"
                        class="text-lg border-b border-slate-400 w-full my-2 ml-8 px-2">
                        @foreach ($group->members as $member)
                        <option value="{{ $member->id }}" @if ($member->id == $group->id_owner) selected @endif>{{
                            $member->username }}</option>
                        @endforeach
                    </select>
                </div>
            </form>
            <div class="flex justify-end items-center w-full">
                @include('partials.components.button', ['id' => 'change-owner-btn', 'icon' => 'fas fa-save', 'color'
                =>
                'green', 'text' => 'Change'])
            </div>
        </div>
    </section>

    <section class="flex flex-col mt-4" id="group-content">
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