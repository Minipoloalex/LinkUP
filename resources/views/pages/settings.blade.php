@extends('layouts.app')

@section('title', 'Settings')

@section('content')
<main id="settings-page" class="flex flex-col items-center justify-center w-full h-full">
    <div class="w-full max-w-md">
        <div class="flex flex-col break-words bg-white border-2 rounded shadow-md">
            <div class="font-semibold bg-gray-200 text-gray-700 py-3 px-6 mb-0">
                Account Settings
            </div>
            
            <form class="w-full p-6" method="POST" action="{{ route('settings.update') }}">
                {{ csrf_field() }}

                <div class="flex flex-wrap mb-6">
                    <label for="username" class="block text-gray-700 text-sm font-bold mb-1">
                        New Username
                    </label>

                    <input id="username" type="text" class="form-input w-full" name="username" value="{{ $user->username }}" required autocomplete="username" autofocus>

                    @error('username')
                    <p class="text-red-500 text-xs italic mt-4">
                        {{ $message }}
                    </p>
                    @enderror
                </div>

                <div class="flex flex-wrap mb-6">
                    <label for="email" class="block text-gray-700 text-sm font-bold mb-1">
                        New Email Address
                    </label>

                    <input id="email" type="email" class="form-input w-full" name="email" value="{{ $user->email }}" required autocomplete="email">

                    @error('email')
                    <p class="text-red-500 text-xs italic mt-4">
                        {{ $message }}
                    </p>
                    @enderror
                </div>

                <div class="flex flex-wrap mb-6">
                    <label for="new_password" class="block text-gray-700 text-sm font-bold mb-1">
                        New Password
                    </label>

                    <input id="new_password" type="password" class="form-input w-full" name="new_password" autocomplete="new-password">

                    @error('new_password')
                    <p class="text-red-500 text-xs italic mt-4">
                        {{ $message }}
                    </p>
                    @enderror

                    <p class="text-gray-600 text-xs italic mt-4">
                        Leave blank to keep your current password.
                    </p>
                </div>

                <div class="flex flex-wrap mb-6">
                    <label for="new_password_confirmation" class="block text-gray-700 text-sm font-bold mb-1">
                        Confirm New Password
                    </label>

                    <input id="new_password_confirmation" type="password" class="form-input w-full" name="new_password_confirmation" autocomplete="new-password">
                </div>

                <div class="flex flex-wrap mb-6">
                    <label for="privacy" class="block text-gray-700 text-sm font-bold mb-1">
                        Privacy
                    </label>

                    <select id="privacy" class="form-input w-full" name="privacy" required>
                        <option value="public" @if (!$user->is_private) selected @endif>Public</option>
                        <option value="private" @if ($user->is_private) selected @endif>Private</option>
                    </select>

                    <p class="text-gray-600 text-xs italic mt-4">
                        If your account is private, only followers can see your posts.
                    </p>
                </div>

                <div class="flex flex-wrap mb-6">
                    <label for="current_password" class="block text-gray-700 text-sm font-bold mb-1">
                        Current Password
                    </label>

                    <input id="current_password" type="password" class="form-input w-full border-b border-black" name="current_password" required autocomplete="current-password">

                    @error('current_password')
                    <p class="text-red-500 text-xs italic mt-4">
                        {{ $message }}
                    </p>
                    @enderror
                </div>

                <button type="submit" class="bg-gray-200 hover:bg-gray-400 text-black font-bold py-2 px-4 rounded mt-3">
                    Update 
                </button>
            </form>
        </div>
    </div>
    @if (session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-3 py-2 rounded relative mt-3" role="alert">
            <span class="block sm:inline">{{ session('success') }}</span>   
        </div>
    @endif
</main>