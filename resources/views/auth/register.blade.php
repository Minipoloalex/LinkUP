@extends('layouts.auth')

@section('content')
<main id="login-page" class="w-screen h-screen flex flex-col items-center justify-center bg-white py-24 mx-auto
                            lg:w-1/2 lg:border-x lg:border-slate-400">
    <img src="{{ url('images/logo.png') }}" alt="Link up logo" class="self-center w-48 mt-4">
    <div class="my-4 text-base font-bold text-center italic">
        <h1>A rede social da UPorto</h1>
    </div>
    <form method="POST" action="{{ route('register') }}" class="col-span-2 flex flex-col flex-grow px-12">
        {{ csrf_field() }}

        <label for="username" class="pt-4 pb-2">username</label>
        <input id="username" type="text" name="username" value="{{ old('username') }}" required autofocus
            class="py-1 pl-2 border border-solid border-slate-400 rounded-md focus:shadow-sm focus:outline-none focus:shadow-zinc-500">

        <label for="email" class="pt-4 pb-2">email</label>
        <input id="email" type="email" name="email" value="{{ old('email') }}" required
            class="py-1 pl-2 border border-solid border-slate-400 rounded-md focus:shadow-sm focus:outline-none focus:shadow-zinc-500">

        <label for="password" class="pt-4 pb-2">password</label>
        <input id="password" type="password" name="password" required
            class="py-1 pl-2 border border-solid border-slate-400 rounded-md focus:shadow-sm focus:outline-none focus:shadow-zinc-500">

        <label for="password-confirm" class="pt-4 pb-2">confirm password</label>
        <input id="password-confirm" type="password" name="password_confirmation" required
            class="py-1 pl-2 border border-solid border-slate-400 rounded-md focus:shadow-sm focus:outline-none focus:shadow-zinc-500">
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

    <div class="w-screen h-12 text-sm text-center absolute top-[90%] left-0">
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