@extends('layouts.app')

<main id="login-page" class="grid grid-cols-4 absolute top-32 left-0 w-screen px-64">
    @include('partials.side.left-tab')
    <form method="POST" action="{{ route('login') }}" class="col-span-2 flex flex-col flex-grow p-24">
        {{ csrf_field() }}

        <label for="login" class="py-2">Username or Email</label>
        <input id="login" type="text" name="login" value="{{ old('login') }}" required autofocus
            class="py-2 pl-1 focus:outline-none">
        @if ($errors->has('login'))
        <span class="error">
            {{ $errors->first('login') }}
        </span>
        @endif

        <label for="password" class="py-2">Password</label>
        <input id="password" type="password" name="password" required class="py-2 pl-1 focus:outline-none">
        @if ($errors->has('password'))
        <span class="error">
            {{ $errors->first('password') }}
        </span>
        @endif

        <label>
            <input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }} class="py-2"> Remember Me
        </label>

        <button type="submit" class="my-2 py-1 border border-solid border-gray-300 bg-slate-200">
            Login
        </button>
        <div class="flex content-center justify-end">
            <a class="button button-outline" href="{{ route('register') }}">Register</a>
        </div>
        @if (session('success'))
        <p class="success">
            {{ session('success') }}
        </p>
        @endif
    </form>
    @include('partials.side.right-tab')
</main>