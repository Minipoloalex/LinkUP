@extends('layouts.auth')

@section('content')
<img src="{{ url('images/background.png') }}" alt="FEUP Jardim"
    class="absolute inset-0 w-full h-full object-cover -z-10">
<main id="login-page"
    class="absolute top-0 left-[61.66%] flex flex-col justify-center self-center content-center bg-white h-screen min-w-[600px]">
    <img src="{{ url('images/logo.png') }}" alt="Link up logo" class="w-1/2 self-center">
    <form method="POST" action="{{ route('register') }}" class="col-span-2 flex flex-col flex-grow px-12">
        {{ csrf_field() }}

        <label for="username" class="pt-2">username</label>
        <input id="username" type="text" name="username" value="{{ old('username') }}" required autofocus
            class="my-2 pl-1 text-sm focus:outline-none border-b border-solid border-slate-400">
        @if ($errors->has('username'))
        <span class="error">
            {{ $errors->first('username') }}
        </span>
        @endif

        <label for="email" class="pt-4">email</label>
        <input id="email" type="email" name="email" value="{{ old('email') }}" required
            class="pt-2 pl-1 text-sm focus:outline-none border-b border-solid border-slate-400">
        @if ($errors->has('email'))
        <span class="error">
            {{ $errors->first('email') }}
        </span>
        @endif

        <label for="password" class="pt-4">password</label>
        <input id="password" type="password" name="password" required
            class="my-2 pl-1 text-sm focus:outline-none border-b border-solid border-slate-400">
        @if ($errors->has('password'))
        <span class="error">
            {{ $errors->first('password') }}
        </span>
        @endif

        <label for="password-confirm" class="pt-4">confirm password</label>
        <input id="password-confirm" type="password" name="password_confirmation" required
            class="my-2 pl-1 text-sm focus:outline-none border-b border-solid border-slate-400">
        <div class="flex justify-end content-center">
            <button type="submit" class="my-2 pt-3 justify-self-end">
                <img src="{{ url('images/icons/login.png') }}" alt="Login" class="w-6 h-6">
            </button>
        </div>
        <div class="flex content-center justify-end text-sm">
            <a class="pt-12 hover:underline" href="{{ route('login') }}">already have an account? login
                here</a>
        </div>
    </form>
</main>
@endsection