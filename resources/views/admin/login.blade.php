@extends('layouts.auth')

@section('content')
<main class="flex flex-col mx-auto">
    <img src="{{ url('images/logo.png') }}" alt="Logo" class="w-1/2 mx-auto mb-4">
    <h1 class="text-center text-2xl mb-4">Administration</h1>
    <form method="POST" action="{{ route('admin.login') }}"
        class="flex flex-col flex-grow justify-center content-center">
        {{ csrf_field() }}

        <label for="email" class="mb-2">Email</label>
        <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus
            class="mb-2 border-b border-slate-400">
        @if ($errors->has('email'))
        <span class="error">
            {{ $errors->first('email') }}
        </span>
        @endif

        <label for="password" class="mb-2">Password</label>
        <input id="password" type="password" name="password" required class="mb-2 border-b border-slate-400">
        @if ($errors->has('password'))
        <span class="error">
            {{ $errors->first('password') }}
        </span>
        @endif

        <div class="flex justify-end">
            <button type="submit" class="my-2 pt-2 justify-self-end">
                <img src="{{ url('images/icons/login.png') }}" alt="Login" class="w-6 h-6">
            </button>
        </div>
    </form>
</main>
@endsection