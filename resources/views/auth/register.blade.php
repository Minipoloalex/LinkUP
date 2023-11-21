@extends('layouts.app')

<main id="login-page" class="grid grid-cols-4 absolute top-32 left-0 w-screen px-64">
    @include('partials.side.left-tab')
    <form method="POST" action="{{ route('register') }}" class="col-span-2 flex flex-col flex-grow p-24">
        {{ csrf_field() }}

        <label for="username" class="py-2">Username</label>
        <input id="username" type="text" name="username" value="{{ old('username') }}" required autofocus
            class="py-2 pl-1 focus:outline-none bg-slate-200">
        @if ($errors->has('username'))
        <span class="error">
            {{ $errors->first('username') }}
        </span>
        @endif

        <label for="email" class="py-2">Email</label>
        <input id="email" type="email" name="email" value="{{ old('email') }}" required
            class="py-2 pl-1 focus:outline-none bg-slate-200">
        @if ($errors->has('email'))
        <span class="error">
            {{ $errors->first('email') }}
        </span>
        @endif

        <label for="password" class="py-2">Password</label>
        <input id="password" type="password" name="password" required class="py-2 pl-1 focus:outline-none bg-slate-200">
        @if ($errors->has('password'))
        <span class="error">
            {{ $errors->first('password') }}
        </span>
        @endif

        <label for="password-confirm" class="py-2">Confirm Password</label>
        <input id="password-confirm" type="password" name="password_confirmation" required
            class="py-2 pl-1 focus:outline-none bg-slate-200">
        <button type="submit" class="mt-8 mb-4 py-1 border border-solid border-gray-300 bg-slate-200">
            Register
        </button>
        <div class="flex content-center justify-end">
            <a class="button button-outline" href="{{ route('login') }}">Login</a>
        </div>
    </form>
    @include('partials.side.right-tab')
</main>