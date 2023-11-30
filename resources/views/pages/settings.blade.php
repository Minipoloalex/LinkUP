@extends('layouts.app')

@section('title', 'Settings')



@section('content')
<main id="settings-page" class="flex flex-col items-center justify-center w-full h-full">
    <div class="w-full max-w-md">
        <div class="flex flex-col break-words bg-white border border-2 rounded shadow-md">
            <div class="font-semibold bg-gray-200 text-gray-700 py-3 px-6 mb-0">
                Settings
            </div>
            
            <form class="w-full p-6" method="POST" action="{{ route('settings.update') }}">
                @csrf

                <div class="flex flex-wrap mb-6">
                    <label for="username" class="block text-gray-700 text-sm font-bold mb-2">
                        Username
                    </label>

                    <input id="username" type="text" class="form-input w-full @error('username') border-red-500 @enderror" name="username" value="{{ $user->username }}" required autocomplete="username" autofocus>

                    @error('username')
                    <p class="text-red-500 text-xs italic mt-4">
                        {{ $message }}
                    </p>
                    @enderror
                </div>

                <div class="flex flex-wrap mb-6">
                    <label for="email" class="block text-gray-700 text-sm font-bold mb-2">
                        Email Address
                    </label>

                    <input id="email" type="email" class="form-input w-full @error('email') border-red-500 @enderror" name="email" value="{{ $user->email }}" required autocomplete="email">

                    @error('email')
                    <p class="text-red-500 text-xs italic mt-4">
                        {{ $message }}
                    </p>
                    @enderror
                </div>

                <div class="flex flex-wrap mb-6">
                    <label for="password" class="block text-gray-700 text-sm font-bold mb-2">
                        Password
                    </label>

                    <input id="password" type="password" class="form-input w-full @error('password') border-red-500 @enderror" name="password" autocomplete="new-password">

                    @error('password')
                    <p class="text-red-500 text-xs italic mt-4">
                        {{ $message }}
                    </p>
                    @enderror
                </div>

                <div class="flex flex-wrap mb-6">
                    <label for
                    ="password-confirm" class="block text-gray-700 text-sm font-bold mb-2">
                        Confirm Password
                    </label>

                    <input id="password-confirm" type="password" class="form-input w-full" name="password_confirmation" autocomplete="new-password">
                </div>

                <button type="submit" class="bg-gray-200 hover:bg-gray-400 text-black font-bold py-2 px-4 rounded">
                    Update Settings
                </button>
            </form>
        
        </div>
    </div>
    @if (session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mt-6" role="alert">
            <span class="block sm:inline">{{ session('success') }}</span>   
        </div>
    @endif
</main>


