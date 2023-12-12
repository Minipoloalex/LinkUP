@extends('layouts.app')

@section('title', 'Settings')

@section('content')
<main id="settings-page" class="flex flex-col items-center justify-center w-full mt-24">
    
    @if (session('success'))
        <div class="w-full max-w-md border-2 border-green-500 mb-6 rounded shadow-md">
            <div class="flex items-center bg-green-500 text-white text-sm px-4 py-3" role="alert">
                <i class="fas fa-check-circle fa-fw mr-3"></i>
                <p>{{ session('success') }}</p>
            </div>
        </div>
    @elseif ($errors->any())
        <div class="w-full max-w-md border-2 border-red-500 mb-6 rounded shadow-md">
            <div class="flex items-center bg-red-500 text-white text-sm px-4 py-3" role="alert">
                <i class="fas fa-exclamation-circle fa-fw mr-3"></i>
                <p>{{ $errors->first() }}</p>
            </div>
        </div>
    @endif

    <div class="w-full max-w-md">
        <div class="flex flex-col break-words bg-white border-2 rounded shadow-md">
            <div class="flex justify-between items-center bg-gray-200 text-gray-700 py-3 px-6 mb-0">
                <h1 class="font-semibold">
                    Account Settings
                </h1>
            </div>

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

                <div class="flex flex-wrap">
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
    </div>
</main>

<script type="module" src="{{ url('js/settings.js') }}"></script>

@endsection