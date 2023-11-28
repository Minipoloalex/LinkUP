@extends('layouts.auth')

@section('content')

<main id="login-page" class="w-screen h-screen flex flex-col items-center justify-center bg-white py-24">
    <img src="{{ url('images/logo.png') }}" alt="Link up logo" class="w-1/2 self-center">
    <div class="my-4 text-base font-bold text-center italic">
        <h1>A rede social da UPorto</h1>
    </div>
    <form method="POST" action="{{ route('login') }}" class="col-span-2 flex flex-col flex-grow my-6 justify-center">
        {{ csrf_field() }}

        <label for="login" class="pt-4 pb-2">username or email</label>
        <input id="login" type="text" name="login" value="{{ old('login') }}" required autofocus
            class="py-1 pl-2 border border-solid border-slate-400 rounded-md focus:shadow-sm focus:outline-none focus:shadow-zinc-500">

        <label for="password" class="pt-4 pb-2">password</label>
        <input id="password" type="password" name="password" required
            class="py-1 pl-2 border border-solid border-slate-400 rounded-md focus:shadow-sm focus:outline-none focus:shadow-zinc-500">

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
            <a class="mt-12 text-sm hover:underline" href="{{ route('register') }}">no account? register here</a>
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
    </div>
</main>
@endsection