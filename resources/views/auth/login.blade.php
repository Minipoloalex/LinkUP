@extends('layouts.auth')

@section('content')
<img src="{{ url('images/feup_jardim.jpg') }}" alt="FEUP Jardim"
    class="absolute inset-0 w-full h-full object-cover -z-10 blur">
<main id="login-page"
    class="flex flex-col justify-center self-center content-center bg-white rounded-md opacity-90 h-1/2 w-3/4">
    <form method="POST" action="{{ route('login') }}" class="col-span-2 flex flex-col flex-grow py-24 my-12 px-12">
        {{ csrf_field() }}

        <label for="login" class="pt-4 pb-2 text-lg">Username or Email</label>
        <input id="login" type="text" name="login" value="{{ old('login') }}" required autofocus
            class="py-2 pl-2 text-sm focus:outline-none border border-solid border-slate-400 rounded-lg">
        @if ($errors->has('login'))
        <span class="error">
            {{ $errors->first('login') }}
        </span>
        @endif

        <label for="password" class="pt-4 pb-2 text-lg">Password</label>
        <input id="password" type="password" name="password" required
            class="py-2 pl-2 text-sm focus:outline-none border border-solid border-slate-400 rounded-lg">
        @if ($errors->has('password'))
        <span class="error">
            {{ $errors->first('password') }}
        </span>
        @endif

        <div class="grid grid-cols-2 gap-2">
            <label class="pt-4 text-center justify-self-start">
                <input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}
                    class="justify-self-start">
                Remember Me
            </label>
            <button type="submit" class="my-2 pt-3 justify-self-end">
                <img src="{{ url('images/icons/login.png') }}" alt="Login" class="w-4 h-4">
            </button>
        </div>
        <div class="flex content-center justify-start">
            <a class="pt-12 text-sm" href="{{ route('register') }}">Register?</a>
        </div>
        @if (session('success'))
        <p class="success">
            {{ session('success') }}
        </p>
        @endif
    </form>
</main>
@endsection