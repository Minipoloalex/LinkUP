@extends('layouts.app')

@section('title', 'Settings')

@section('content')
<main id="settings-page" class="flex flex-col items-center justify-center w-full mt-24">

    <div class="w-full max-w-md">
        <div class="flex flex-col break-words bg-white border-2 rounded shadow-md">
            
            <div class="flex justify-between items-center bg-gray-200 text-gray-700 py-3 px-6 mb-0">
                <button id="account-settings-toggle" class="font-semibold focus:outline-none @if ($activeSection == 'account') border-b-2 border-black @endif">
                    Account
                </button>
                <button id="profile-settings-toggle" class="font-semibold focus:outline-none @if ($activeSection == 'profile') border-b-2 border-black @endif">
                    Profile
                </button>
            </div>
            
            <div id="account-settings" class="@if ($activeSection == 'account') block @else hidden @endif">
                <form id="account-settings-form" class="w-full p-6" method="POST" action="{{ route('settings.update') }}">
                    @csrf
                    @method('POST')

                    <div class="flex flex-wrap mb-6">
                        <label for="username" class="block text-gray-700 text-sm font-bold mb-1">
                            New Username
                        </label>

                        <input id="username" type="text" class="form-input w-full focus:outline-none" name="username" value="{{ $user->username }}" required autocomplete="username" autofocus>
                        
                    </div>

                    <div class="flex flex-wrap mb-6">
                        <label for="email" class="block text-gray-700 text-sm font-bold mb-1">
                            New Email Address
                        </label>

                        <input id="email" type="email" class="form-input w-full focus:outline-none" name="email" value="{{ $user->email }}" required autocomplete="email">
                    </div>

                    <div class="flex flex-wrap mb-6">
                        <label for="password" class="block text-gray-700 text-sm font-bold mb-1">
                            New Password
                        </label>

                        <input id="password" type="password" class="form-input w-full focus:outline-none" name="password" autocomplete="password">

                        <p class="text-gray-600 text-xs italic mt-4">
                            Leave blank to keep your current password.
                        </p>
                    </div>

                    <div class="flex flex-wrap mb-6">
                        <label for="password_confirmation" class="block text-gray-700 text-sm font-bold mb-1">
                            Confirm New Password
                        </label>

                        <input id="password_confirmation" type="password" class="form-input w-full focus:outline-none" name="password_confirmation" autocomplete="password">
                    </div>

                    <div class="flex flex-wrap mb-6">
                        <label for="privacy" class="block text-gray-700 text-sm font-bold mb-1">
                            Privacy
                        </label>

                        <select id="privacy" class="form-input w-full focus:outline-none" name="privacy" required>
                            <option value="public" @if (!$user->is_private) selected @endif>Public</option>
                            <option value="private" @if ($user->is_private) selected @endif>Private</option>
                        </select>

                        <p class="text-gray-600 text-xs italic mt-4">
                            If your account is private, only followers can see your posts.
                        </p>
                    </div>
                </form>
               
                <div class="flex flex-wrap p-6">
                    <button id="account-update-button" class="bg-gray-200 hover:bg-gray-400 text-black font-bold py-2 px-4 rounded">
                        Update
                    </button>
                </div>

            </div>

            <div id="profile-settings" class="@if ($activeSection == 'profile') block @else hidden @endif">
                <form class="w-full p-6" method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data">
                    @csrf
                    @method('POST')

                    <div class="flex flex-wrap mb-6">
                        <label for="name" class="block text-gray-700 text-sm font-bold mb-1">
                            Name
                        </label>

                        <input id="name" type="text" class="form-input w-full focus:outline-none" name="name" value="{{ $user->name }}" required autocomplete="name" autofocus>

                        <p class="text-gray-600 text-xs italic mt-4">
                            Your name will be displayed on your profile.
                        </p>
                    </div>

                    <div class="flex flex-wrap mb-6">
                        <label for="faculty" class="block text-gray-700 text-sm font-bold mb-1">
                            Faculty
                        </label>

                        <select id="faculty" class="form-input w-full focus:outline-none" name="faculty" required>
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
                        <label for="course" class="block text-gray-700 text-sm font-bold mb-1">
                            Course
                        </label>

                        <input id="course" type="text" class="form-input w-full" name="course" value="{{ $user->course }}" autocomplete="course">
                    </div>

                    <div class="flex flex-wrap mb-6">
                        <label for="bio" class="block text-gray-700 text-sm font-bold mb-1">
                            Bio
                        </label>

                        <textarea id="bio" class="form-input w-full resize-none h-16 border-none focus:outline-none" name="bio" autocomplete="bio">{{ $user->bio }}</textarea>

                        <p class="text-gray-600 text-xs italic mt-4">
                            Let fellow students know a little about you.
                        </p>
                    </div>

                    <label for="media" class="block text-gray-700 text-sm font-bold mb-6">
                        Profile Picture 
                    </label>
                    
                    <p class="text-gray-600 text-xs italic mb-6">
                        Upload a profile picture to make your account more recognizable.
                    </p>    
                    
                    <div class="file-input-wrapper grid grid-cols-2 gap-4 w-full bg-gray-100 rounded-lg p-6">
                        <div class="flex flex-col items-center justify-center">
                            <img class="image-preview w-24 h-24 rounded-full" src="{{ route('profile.photo', ['id' => $user->id]) }}" alt="Profile Picture">
                        </div>

                        <div class="flex flex-col items-center justify-center">
                            <input type="file" id="media" name="media" accept="image/*" class="hidden">
                            @include('partials.images_crop_input')
                            <button id="media-button" type="button" class="border border-gray-400 hover:border-gray-500 bg-white hover:bg-gray-100 text-black font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline"
                            onclick="document.getElementById('media').click()">
                                Edit
                            </button>
                        </div>
                    </div>
                    
                    <button type="submit" class="bg-gray-200 hover:bg-gray-400 text-black font-bold py-2 px-4 rounded mt-6">
                        Update
                    </button>
                </form>
            </div>
        </div>
    </div>

    @if (session('success'))
        <div class="w-full max-w-md border-2 border-green-500 mt-6 rounded shadow-md">
            <div class="flex items-center bg-green-500 text-white text-sm px-4 py-3" role="alert">
                <i class="fas fa-check-circle fa-fw mr-3"></i>
                <p>{{ session('success') }}</p>
            </div>
        </div>
    @elseif ($errors->any())
        <div class="w-full max-w-md border-2 border-red-500 mt-6 rounded shadow-md">
            <div class="flex items-center bg-red-500 text-white text-sm px-4 py-3" role="alert">
                <i class="fas fa-exclamation-circle fa-fw mr-3"></i>
                <p>{{ $errors->first() }}</p>
            </div>
        </div>
    @endif

</main>

<script type="module" src="{{ url('js/settings.js') }}"></script>

@endsection