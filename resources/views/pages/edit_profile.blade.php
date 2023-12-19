@php
$activePage = 'profile';
@endphp
@extends('layouts.app')

@section('title', 'Edit Profile')

@section('content')

<main id="edit-profile" class="flex flex-col w-screen overflow-clip overflow-y-scroll h-[calc(100vh-6rem)] scrollbar-hide
                                lg:w-full">
    @if (session('success'))
    <div class="w-full border-2 border-green-500 mb-6 rounded shadow-md">
        <div class="flex items-center bg-green-500 text-white text-sm px-4 py-3" role="alert">
            <i class="fas fa-check-circle fa-fw mr-3"></i>
            <p>{{ session('success') }}</p>
        </div>
    </div>
    @elseif ($errors->any())
    <div class="w-full border-2 border-red-500 mb-6 rounded shadow-md">
        <div class="flex items-center bg-red-500 text-white text-sm px-4 py-3" role="alert">
            <i class="fas fa-exclamation-circle fa-fw mr-3"></i>
            <p>{{ $errors->first() }}</p>
        </div>
    </div>
    @endif

    <div class="w-full">
        <div class="relative flex flex-col break-words dark:bg-dark-primary dark:text-dark-secondary">
            <div class="flex justify-between items-center py-3 px-6 mb-0 border-b-2 sticky top-0 left-0 dark:bg-dark-primary z-[2]
                        dark:border-dark-neutral">
                <h1 class="font-semibold">
                    Edit Profile
                </h1>
                <a href="{{ route('profile.show', ['username' => $user->username]) }}" class="text-sm">
                    Cancel
                </a>
            </div>

            <form class="w-full px-8 py-2 space-y-8 overflow-clip overflow-y-scroll scrollbar-hide" method="POST"
                action="{{ route('profile.update') }}" enctype="multipart/form-data">
                @csrf
                @method('POST')

                <div class="flex flex-wrap w-full">
                    <div class="relative w-full">
                        <input id="name" name="name" type="text" class="peer h-10 w-full
                            dark:bg-dark-primary border-b-2 dark:border-dark-secondary dark:text-dark-secondary 
                              text-sm placeholder-transparent focus:outline-none dark:focus:border-dark-active"
                            placeholder="Name" value="{{ $user->name }}" />
                        <label for="name" class="absolute left-0 -top-3.5 text-sm transition-all peer-placeholder-shown:text-base 
                                        dark:peer-placeholder-shown:text-dark-secondary peer-placeholder-shown:top-2 peer-focus:-top-3.5 
                                        dark:peer-focus:text-dark-active peer-focus:text-sm">
                            Name
                        </label>
                    </div>


                    <p class="text-xs italic mt-4">
                        Your name will be displayed on your profile.
                    </p>
                </div>

                <div class="mt-2 flex w-full items-center">
                    <label for="faculty" class="duration-200
                        dark:peer-focus:text-dark-active peer-focus:text-sm">Faculty</label>
                    <select id="faculty" name="faculty" required class="appearance-none peer h-8 w-full ml-4
                            dark:bg-dark-primary border-b-2 dark:border-dark-secondary dark:text-dark-secondary 
                                text-sm placeholder-transparent focus:outline-none dark:focus:border-dark-active">}}
                        <option value="faup" @if ($user->faculty == 'faup') selected @endif>FAUP</option>
                        <option value="fbaup" @if ($user->faculty == 'fbaup') selected @endif>FBAUP</option>
                        <option value="fcup" @if ($user->faculty == 'fcup') selected @endif>FCUP</option>
                        <option value="fcnaup" @if ($user->faculty == 'fcnaup') selected @endif>FCNAUP</option>
                        <option value="fadeup" @if ($user->faculty == 'fadeup') selected @endif>FADEUP</option>
                        <option value="fdup" @if ($user->faculty == 'fdup') selected @endif>FDUP</option>
                        <option value="fep" @if ($user->faculty == 'fep') selected @endif>FEP</option>
                        <option value="feup" @if ($user->faculty == 'feup') selected @endif>FEUP</option>
                        <option value="ffup" @if ($user->faculty == 'ffup') selected @endif>FFUP</option>
                        <option value="flup" @if ($user->faculty == 'flup') selected @endif>FLUP</option>
                        <option value="fmup" @if ($user->faculty == 'fmup') selected @endif>FMUP</option>
                        <option value="fmdup" @if ($user->faculty == 'fmdup') selected @endif>FMDUP</option>
                        <option value="fpceup" @if ($user->faculty == 'fpceup') selected @endif>FPCEUP</option>
                        <option value="icbas" @if ($user->faculty == 'icbas') selected @endif>ICBAS</option>
                    </select>
                </div>

                <div class="flex flex-wrap mb-6">
                    <div class="relative w-full">
                        <input id="course" type="text" name="course" value="{{ $user->course }}" class="peer h-10 w-full
                            dark:bg-dark-primary border-b-2 dark:border-dark-secondary dark:text-dark-secondary 
                              text-sm placeholder-transparent focus:outline-none dark:focus:border-dark-active"
                            placeholder="Course" value="{{ $user->course }}" />
                        <label for="course" class="absolute left-0 -top-3.5 text-sm transition-all peer-placeholder-shown:text-base 
                                        dark:peer-placeholder-shown:text-dark-secondary peer-placeholder-shown:top-2 peer-focus:-top-3.5 
                                        dark:peer-focus:text-dark-active peer-focus:text-sm">
                            Course
                        </label>
                    </div>
                </div>

                <div class="flex flex-wrap mb-6">
                    <div class="relative w-full">
                        <textarea id="bio" type="text" name="bio" value="{{ $user->course }}" class="peer h-16 w-full mt-2
                            dark:bg-dark-primary border-b-2 dark:border-dark-secondary dark:text-dark-secondary 
                              text-sm placeholder-transparent focus:outline-none dark:focus:border-dark-active"
                            placeholder="Bio">{{ $user->bio }}</textarea>
                        <label for="bio" class="absolute left-0 -top-3.5 text-sm transition-all peer-placeholder-shown:text-base 
                                        dark:peer-placeholder-shown:text-dark-secondary peer-placeholder-shown:top-2 peer-focus:-top-3.5 
                                        dark:peer-focus:text-dark-active peer-focus:text-sm">
                            Bio
                        </label>
                    </div>

                    <p class="text-xs italic mt-4">
                        Let fellow students know a little about you.
                    </p>
                </div>

                <div>
                    <label for="media" class="block text-sm font-bold mb-2">
                        Profile Picture
                    </label>

                    <div class="file-input-wrapper grid grid-cols-2 gap-4 w-full p-6">
                        <div class="flex flex-col items-center justify-center">
                            <img class="image-preview w-24 h-24 rounded-full"
                                src="{{ route('profile.photo', ['id' => $user->id]) }}" alt="Profile Picture">
                        </div>

                        <div class="flex flex-col items-center justify-center">
                            <input type="file" id="media" name="media" accept="image/*" class="hidden">
                            @include('partials.images_crop_input')
                            <button id="media-button" type="button"
                                class="border border-gray-400 hover:border-gray-500 dark:bg-dark-active dark:text-dark-secondary font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline"
                                onclick="document.getElementById('media').click()">
                                Edit
                            </button>
                        </div>
                    </div>
                    <p class="text-xs italic mt-2">
                        Upload a profile picture to make your account more recognizable.
                    </p>
                </div>

                <div class="w-full flex items-center justify-end">
                    <button type="submit"
                        class="dark:bg-dark-active dark:text-dark-secondary font-bold py-2 px-4 rounded mt-6">
                        Update
                    </button>
                </div>

                <div class="filler h-16"></div>
            </form>
        </div>
    </div>
</main>

@endsection