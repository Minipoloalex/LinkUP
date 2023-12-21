@php
$activePage = 'settings';
@endphp
@extends('layouts.app')

@section('title', 'Settings')

@push('scripts')
<script type="module" src="{{ url('js/settings.js') }}"></script>
@endpush


@section('content')
<main id="settings-page" class="flex flex-col w-screen overflow-clip overflow-y-scroll h-[calc(100vh-6rem)] scrollbar-hide
                            lg:w-full">
                            
    <div class="w-full">
        <div class="flex flex-col break-words rounded">
            <div class="flex justify-between items-center py-3 px-6 mb-0">
                <h1 class="font-semibold">
                    Account Settings
                </h1>
            </div>

            <form id="account-settings-form" class="w-full p-6" method="POST" action="{{ route('settings.update') }}">
                @csrf
                @method('POST')

                <div class="flex flex-wrap mb-6 group">
                    <label for="username" class="block text-sm font-bold mb-1 group-focus-within:dark:text-dark-active">
                        New Username
                    </label>

                    <input id="username" type="text"
                        class="form-input w-full focus:outline-none dark:bg-dark-primary border-b" name="username"
                        value="{{ $user->username }}" required autocomplete="username">

                    @if ($errors->has('username'))
                    <p class="error text-red-500 text-xs py-2"> {{ $errors->first('username') }} </p>
                    @endif
                </div>

                <div class="flex flex-wrap mb-6 group">
                    <label for="email" class="block  text-sm font-bold mb-1 group-focus-within:dark:text-dark-active">
                        New Email Address
                    </label>

                    <input id="email" type="email"
                        class="form-input w-full focus:outline-none dark:bg-dark-primary border-b" name="email"
                        value="{{ $user->email }}" required autocomplete="email">

                    @if ($errors->has('email'))
                    <p class="error text-red-500 text-xs py-2"> {{ $errors->first('email') }} </p>
                    @endif
                </div>

                <div class="flex flex-wrap mb-6 group">
                    <label for="password"
                        class="block  text-sm font-bold mb-1 group-focus-within:dark:text-dark-active">
                        New Password
                    </label>

                    <input id="password" type="password"
                        class="form-input w-full focus:outline-none dark:bg-dark-primary border-b" name="password"
                        autocomplete="password">

                    <p class="text-xs italic mt-4">
                        Leave blank to keep your current password.
                    </p>

                    @if ($errors->has('password'))
                    <p class="error text-red-500 text-xs py-2"> {{ $errors->first('password') }} </p>
                    @endif
                </div>

                <div class="flex flex-wrap mb-6 group">
                    <label for="password_confirmation"
                        class="block  text-sm font-bold mb-1 group-focus-within:dark:text-dark-active">
                        Confirm New Password
                    </label>

                    <input id="password_confirmation" type="password"
                        class="form-input w-full focus:outline-none dark:bg-dark-primary border-b"
                        name="password_confirmation" autocomplete="password">
                </div>

                <div class="flex flex-wrap group">
                    <label for="privacy" class="block  text-sm font-bold mb-1 group-focus-within:dark:text-dark-active">
                        Privacy
                    </label>

                    <select id="privacy"
                        class="form-input w-full focus:outline-none dark:bg-dark-primary border-b dark:border-dark-secondary"
                        name="privacy" required>
                        <option value="public" @if (!$user->is_private) selected @endif>Public</option>
                        <option value="private" @if ($user->is_private) selected @endif>Private</option>
                    </select>

                    <p class="text-xs italic mt-4">
                        If your account is private, only followers can see your posts.
                    </p>
                </div>
            </form>

            <div class="flex w-full items-center justify-end px-6">
                <button id="account-update-button"
                    class="font-bold py-2 px-4 rounded dark:bg-dark-active cursor-pointer">
                    Update
                </button>
            </div>
        </div>

        <div class="flex flex-col break-words border-t dark:border-dark-neutral mt-6">
            <div class="flex justify-between items-center py-3 px-6 mb-0">
                <h1 class="font-semibold">
                    Delete Account
                </h1>
            </div>

            <div class="w-full px-6 py-2">
                <p class=" text-sm">
                    This action cannot be undone.
                </p>
            </div>

            <div class="flex w-full items-center justify-end px-6 pb-6">
                <button id="account-delete-button"
                    class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">
                    Delete
                </button>
            </div>

            <form id="account-delete-form" method="POST" action="{{ route('settings.delete') }}">
                @csrf
                @method('POST')
            </form>
        </div>
    </div>
</main>

<script type="module" src="{{ url('js/settings.js') }}"></script>

@endsection