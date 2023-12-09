@extends('layouts.auth')

@section('content')

<main id="login-page" class="py-12 px-4 flex flex-col items-center">
    <form method="POST" action="{{ route('login') }}" class="flex flex-col justify-center w-64 space-y-8">
        {{ csrf_field() }}

        <div class="relative">
            <input id="login" name="login" type="text" required value="{{ old('login') }}" class="peer h-10 w-full
            dark:bg-dark-primary border-b-2 dark:border-dark-secondary dark:text-dark-secondary 
                text-sm placeholder-transparent focus:outline-none dark:focus:border-dark-active"
                placeholder="username or email" />
            <label for="login" class="absolute left-0 -top-3.5 text-sm transition-all peer-placeholder-shown:text-base 
            dark:peer-placeholder-shown:text-dark-secondary peer-placeholder-shown:top-2 peer-focus:-top-3.5 
            dark:peer-focus:text-dark-active peer-focus:text-sm">
                Username or Email
            </label>
        </div>

        <div class="relative">
            <input id="password" name="password" type="password" required value="{{ old('login') }}" class="peer h-10 w-full
            dark:bg-dark-primary border-b-2 dark:border-dark-secondary dark:text-dark-secondary 
                text-sm placeholder-transparent focus:outline-none dark:focus:border-dark-active"
                placeholder="password" />
            <label for="password" class="absolute left-0 -top-3.5 text-sm transition-all peer-placeholder-shown:text-base 
                dark:peer-placeholder-shown:text-dark-secondary peer-placeholder-shown:top-2 peer-focus:-top-3.5 
                dark:peer-focus:text-dark-active peer-focus:text-sm">
                Password
            </label>
        </div>

        <div class="text-sm flex items-center justify-end relative">
            <label for="remember"> Remember Me </label>
            <input id="remember" type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }} class="
                    appearance-none w-4 h-4 rounded dark:bg-dark-secondary flex items-center justify-center peer
                    ml-2 dark:checked:bg-dark-active" />
            <i class="fas fa-check absolute right-[2px] top-1 pointer-events-none"></i>
        </div>

        <button type=" submit" class="w-full dark:bg-dark-active rounded-xl h-10">
            login
        </button>

        <div class="flex flex-col items-end justify-center space-y-2">
            <a class="text-sm dark:hover:text-dark-active" href="{{ route('register') }}">no account?
                register
                here</a>
            <a class="text-sm dark:hover:text-dark-active" href="{{ route('password.request') }}">forgot your
                password?</a>
        </div>
    </form>

    <div class="w-screen h-12 text-sm text-center absolute top-[80%] left-0">
        @if (session('success'))
        <p class="success text-green-500"> {{ session('success') }} </p>
        @endif
        @if ($errors->has('login'))
        <p class="error text-red-500"> {{ $errors->first('login') }} </p>
        @endif
        @if ($errors->has('password'))
        <p class="error text-red-500"> {{ $errors->first('password') }} </p>
        @endif
        @if (session('error'))
        <p class="error text-red-500"> {{ session('error') }} </p>
        @endif
    </div>
</main>
@endsection