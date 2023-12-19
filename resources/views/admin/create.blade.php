@extends('layouts.admin')

@section('content')
<form method="POST" action="{{ route('admin.create') }}" class="flex flex-col w-full items-center justify-center gap-6">
    {{ csrf_field() }}

    <h1 class="text-2xl font-bold">Create Admin</h1>

    <div class="relative">
        <input id="email" name="email" type="text" required class="peer h-10 w-full
            dark:bg-dark-primary border-b-2 dark:border-dark-secondary dark:text-dark-secondary 
                text-sm placeholder-transparent focus:outline-none dark:focus:border-dark-active"
            placeholder="Email" />
        <label for="email" class="absolute left-0 -top-3.5 text-sm transition-all peer-placeholder-shown:text-base 
            dark:peer-placeholder-shown:text-dark-secondary peer-placeholder-shown:top-2 peer-focus:-top-3.5 
            dark:peer-focus:text-dark-active peer-focus:text-sm">
            Email
        </label>
    </div>

    <div class="relative">
        <input id="password" name="password" type="password" required class="peer h-10 w-full
            dark:bg-dark-primary border-b-2 dark:border-dark-secondary dark:text-dark-secondary 
                text-sm placeholder-transparent focus:outline-none dark:focus:border-dark-active"
            placeholder="Password" />
        <label for="password" class="absolute left-0 -top-3.5 text-sm transition-all peer-placeholder-shown:text-base 
            dark:peer-placeholder-shown:text-dark-secondary peer-placeholder-shown:top-2 peer-focus:-top-3.5 
            dark:peer-focus:text-dark-active peer-focus:text-sm">
            Password
        </label>
    </div>

    <div class="relative">
        <input id="password_confirmation" name="password_confirmation" type="password" required class="peer h-10 w-full
            dark:bg-dark-primary border-b-2 dark:border-dark-secondary dark:text-dark-secondary 
                text-sm placeholder-transparent focus:outline-none dark:focus:border-dark-active"
            placeholder="Confirm Password" />
        <label for="password_confirmation" class="absolute left-0 -top-3.5 text-sm transition-all peer-placeholder-shown:text-base 
            dark:peer-placeholder-shown:text-dark-secondary peer-placeholder-shown:top-2 peer-focus:-top-3.5 
            dark:peer-focus:text-dark-active peer-focus:text-sm">
            Confirm Password
        </label>
    </div>

    <button type="submit" class="dark:bg-dark-active rounded-xl w-[10vw] h-10">
        Create
    </button>

    <span class="success bg-green-500 rounded-lg text-white w-[20vw] flex items-center justify-center">
        @if (session('success'))
        <h2 class="my-1">{{ session('success') }}</h2>
        @endif
    </span>
</form>
@endsection