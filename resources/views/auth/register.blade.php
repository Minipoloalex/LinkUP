@extends('layouts.app')

@section('title', 'Register')
@section('content')
<main id="register-page" class="flex flex-col w-screen overflow-clip overflow-y-scroll h-[calc(100vh-10rem)] scrollbar-hide
                                lg:w-full">
    <form method="POST" action="{{ route('register') }}"
        class="flex flex-col items-center justify-center w-1/3 mx-auto h-full gap-8 min-w-max">
        {{ csrf_field() }}

        <div class="relative w-full">
            <input id="username" name="username" type="text" required class="peer h-10 w-full
            dark:bg-dark-primary border-b-2 dark:border-dark-secondary dark:text-dark-secondary 
                text-sm placeholder-transparent focus:outline-none dark:focus:border-dark-active"
                placeholder="username" />
            <label for="username" class="absolute left-0 -top-3.5 text-sm transition-all peer-placeholder-shown:text-base 
            dark:peer-placeholder-shown:text-dark-secondary peer-placeholder-shown:top-2 peer-focus:-top-3.5 
            dark:peer-focus:text-dark-active peer-focus:text-sm">
                Username
            </label>
            @if ($errors->has('username'))
            <p class="error text-red-500 text-xs py-2"> {{ $errors->first('username') }} </p>
            @endif
        </div>

        <div class="relative w-full">
            <select id="faculty" name="faculty" required class="peer h-10 w-full
            dark:bg-dark-primary border-b-2 dark:border-dark-secondary dark:text-dark-secondary 
                text-sm placeholder-transparent focus:outline-none dark:focus:border-dark-active">
                <option value="" disabled selected hidden></option>
                <option value="faup">FAUP</option>
                <option value="fbaup">FBAUP</option>
                <option value="fcup">FCUP</option>
                <option value="fcnaup">FCNAUP</option>
                <option value="fadeup">FADEUP</option>
                <option value="fdup">FDUP</option>
                <option value="fep">FEP</option>
                <option value="feup">FEUP</option>
                <option value="ffup">FFUP</option>
                <option value="flup">FLUP</option>
                <option value="fmup">FMUP</option>
                <option value="fmdup">FMDUP</option>
                <option value="fpceup">FPCEUP</option>
                <option value="icbas">ICBAS</option>
            </select>
            <label for="faculty" class="absolute left-0 top-2.5 duration-200 origin-0
            dark:peer-focus:text-dark-active peer-focus:text-sm">Faculty</label>

            @if ($errors->has('faculty'))
            <p class="error text-red-500 text-xs py-2"> {{ $errors->first('faculty') }} </p>
            @endif
        </div>

        <div class="relative w-full">
            <input id="email" name="email" type="text" required class="peer h-10 w-full
            dark:bg-dark-primary border-b-2 dark:border-dark-secondary dark:text-dark-secondary 
                text-sm placeholder-transparent focus:outline-none dark:focus:border-dark-active"
                placeholder="email" />
            <label for="email" class="absolute left-0 -top-3.5 text-sm transition-all
            peer-placeholder-shown:text-base
            dark:peer-placeholder-shown:text-dark-secondary peer-placeholder-shown:top-2 peer-focus:-top-3.5
            dark:peer-focus:text-dark-active peer-focus:text-sm">
                Email
            </label>

            @if ($errors->has('email'))
            <p class="error text-red-500 text-xs py-2"> {{ $errors->first('email') }} </p>
            @endif
        </div>

        <div class="relative w-full">
            <input id="password" name="password" type="password" required value="{{ old('login') }}" class="peer h-10 w-full
            dark:bg-dark-primary border-b-2 dark:border-dark-secondary dark:text-dark-secondary 
                text-sm placeholder-transparent focus:outline-none dark:focus:border-dark-active"
                placeholder="password" />
            <label for="password" class="absolute left-0 -top-3.5 text-sm transition-all peer-placeholder-shown:text-base 
                dark:peer-placeholder-shown:text-dark-secondary peer-placeholder-shown:top-2 peer-focus:-top-3.5 
                dark:peer-focus:text-dark-active peer-focus:text-sm">
                Password
            </label>

            @if ($errors->has('password'))
            <p class="error text-red-500 text-xs py-2"> {{ $errors->first('password') }} </p>
            @endif
        </div>

        <div class="relative w-full">
            <input id="password-confirm" name="password_confirmation" type="password" required class="peer h-10 w-full
            dark:bg-dark-primary border-b-2 dark:border-dark-secondary dark:text-dark-secondary 
                text-sm placeholder-transparent focus:outline-none dark:focus:border-dark-active"
                placeholder="confirm password" />
            <label for="password-confirm" class="absolute left-0 -top-3.5 text-sm transition-all peer-placeholder-shown:text-base 
                dark:peer-placeholder-shown:text-dark-secondary peer-placeholder-shown:top-2 peer-focus:-top-3.5 
                dark:peer-focus:text-dark-active peer-focus:text-sm">
                Confirm password
            </label>
        </div>

        <button type=" submit" class="w-full dark:bg-dark-active rounded-xl h-10">
            Create Account
        </button>

        <div class="flex flex-col items-end justify-center w-full">
            <a class="text-sm text-right dark:hover:text-dark-active" href="{{ route('login') }}">
                already have an account? <br> login here
            </a>
        </div>
    </form>
</main>
@endsection