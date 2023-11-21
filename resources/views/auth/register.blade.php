@extends('layouts.auth')

@section('content')
<img src="{{ url('images/feup_jardim.jpg') }}" alt="FEUP Jardim"
    class="absolute inset-0 w-full h-full object-cover -z-10 blur">
<main id="login-page"
    class="flex flex-col justify-center self-center content-center bg-white rounded-md opacity-90 h-1/2 w-3/4">
    <form method="POST" action="{{ route('register') }}" class="col-span-2 flex flex-col flex-grow py-24 my-12 px-12">
        {{ csrf_field() }}

        <label for="username" class="py-2">Username</label>
        <input id="username" type="text" name="username" value="{{ old('username') }}" required autofocus
            class="py-2 pl-2 text-sm focus:outline-none border border-solid border-slate-400 rounded-lg">
        @if ($errors->has('username'))
        <span class="error">
            {{ $errors->first('username') }}
        </span>
        @endif

        <label for="email" class="py-2">Email</label>
        <input id="email" type="email" name="email" value="{{ old('email') }}" required
            class="py-2 pl-2 text-sm focus:outline-none border border-solid border-slate-400 rounded-lg">
        @if ($errors->has('email'))
        <span class="error">
            {{ $errors->first('email') }}
        </span>
        @endif

        <label for="password" class="py-2">Password</label>
        <input id="password" type="password" name="password" required
            class="py-2 pl-2 text-sm focus:outline-none border border-solid border-slate-400 rounded-lg">
        @if ($errors->has('password'))
        <span class="error">
            {{ $errors->first('password') }}
        </span>
        @endif

        <label for="password-confirm" class="py-2">Confirm Password</label>
        <input id="password-confirm" type="password" name="password_confirmation" required
            class="py-2 pl-2 text-sm focus:outline-none border border-solid border-slate-400 rounded-lg">
        <div class="flex justify-end content-center">
            <button type="submit" class="my-2 pt-3 justify-self-end">
                <img src="{{ url('images/icons/login.png') }}" alt="Login" class="w-4 h-4">
            </button>
        </div>
        <div class="flex content-center justify-start text-sm">
            <a class="button button-outline" href="{{ route('login') }}">Login?</a>
        </div>
    </form>
</main>
@endsection