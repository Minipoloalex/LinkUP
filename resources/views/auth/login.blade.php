@extends('layouts.auth')

@section('content')
<img src="{{ url('images/background.png') }}" alt="UP Colors Background"
    class="absolute inset-0 w-full h-full object-cover -z-10">
<main id="login-page"
    class="absolute top-0 left-[61.66%] flex flex-col justify-center self-center content-center bg-white h-screen min-w-[600px]">
    <img src="{{ url('images/logo.png') }}" alt="Link up logo" class="w-1/2 self-center">
    <form method="POST" action="{{ route('login') }}" class="col-span-2 flex flex-col flex-grow my-6 px-12">
        {{ csrf_field() }}

        <label for="login" class="pt-4 pb-2 text-lg">username or email</label>
        <input id="login" type="text" name="login" value="{{ old('login') }}" required autofocus
            class="pb-1 pl-2 text-sm focus:outline-none border-b border-solid border-slate-400">
        @if ($errors->has('login'))
        <span class="error">
            {{ $errors->first('login') }}
        </span>
        @endif

        <label for="password" class="pt-4 pb-2 text-lg">password</label>
        <input id="password" type="password" name="password" required
            class="pb-1 pl-2 text-sm focus:outline-none border-b border-solid border-slate-400">
        @if ($errors->has('password'))
        <span class="error">
            {{ $errors->first('password') }}
        </span>
        @endif

        <div class="grid grid-cols-2 gap-2 mt-1">
            <label class="pt-4 pl-1 inline-block whitespace-nowrap align-middle">
                <input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}
                    class="justify-self-start align-middle" />
                remember me
            </label>
            <button type="submit" class="my-2 pt-2 justify-self-end">
                <img src="{{ url('images/icons/login.png') }}" alt="Login" class="w-6 h-6">
            </button>
        </div>
        <div class="flex mt-6 mr-2 content-center justify-end">
            <a class="pt-12 text-sm hover:underline" href="{{ route('register') }}">no account? register here</a>
        </div>
        @if (session('success'))
        <p class="success">
            {{ session('success') }}
        </p>
        @endif
    </form>
</main>
@endsection