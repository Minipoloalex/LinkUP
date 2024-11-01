@extends('layouts.auth')

@section('content')

<main id="forgot-password" class="flex flex-col items-center justify-center w-full mt-16">
    <div class="w-full max-w-md">
        <div class="flex flex-col break-words bg-transparent border-2 border-dark-active rounded-lg shadow-md p-8">
                
            <div class="font-bold  py-3 px-6">
                Recover Your Password 
            </div>

            <div class="w-full p-6">
                <p class="text-sm">
                    Please enter your email address. You will receive a link to reset your password. 
                </p>
            </div>

            <form class="w-full p-6" method="POST" action="{{ route('password.email') }}">
                {{ csrf_field() }}

                <div class="flex flex-wrap mb-6">
                    <label for="email" class="block text-sm mb-2 font-semibold">
                        Email Address
                        <span class="text-red-500 text-xs italic">*</span>
                    </label>

                    <input id="email" type="email" class="form-input py-1 w-full bg-transparent outline-none border-b-2 border-dark-active {{ $errors->has('email') ? ' border-red-500' : '' }}" name="email" value="{{ old('email') }}" required>

                    
                </div>

                <div class="flex flex-wrap mt-16 mb-8">
                    <button type="submit" class="bg-dark-active font-bold py-2 px-4 rounded text-sm">
                        Send 
                        <i class="fas fa-paper-plane fa-fw ml-1"></i>
                    </button>
                </div>

                <div class="flex flex-wrap">
                    <a class="text-blue-400 hover:text-blue-500 text-sm" href="{{ route('login') }}">
                        <i class="fas fa-arrow-left fa-fw"></i>
                        Back to login
                    </a>
                </div>
            </form>
        </div>
    </div>

    @if (session('status'))
        <div class="w-full max-w-md border-2 border-green-500 mt-6 rounded shadow-md">
            <div class="flex items-center bg-green-500 text-white text-sm px-4 py-3" role="alert">
                <i class="fas fa-check-circle fa-fw mr-3"></i>
                <p>{{ session('status') }}</p>
            </div>
        </div>
    @elseif ($errors->any())
        <div class="w-full max-w-md border-2 border-red-500 mt-6 rounded shadow-md">
            <div class="flex items-center bg-red-500 text-white text-sm px-4 py-3" role="alert">
                <i class="fas fa-exclamation-circle fa-fw mr-3"></i>
                <p>{{ $errors->first() }}</p>
            </div>
        </div>
    @endif
    
</main>

@endsection