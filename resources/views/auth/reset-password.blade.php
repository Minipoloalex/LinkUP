@extends('layouts.auth')

@section('content')

<main id="forgot-password" class="flex flex-col items-center justify-center w-full mt-24">
    <div class="w-full max-w-md">
        <div class="flex flex-col break-words bg-white border-2 rounded shadow-md">
                
            <div class="font-bold bg-gray-200 text-gray-700 py-3 px-6">
                Reset Your Password
            </div>
            
            <div class="w-full p-6">
                <p class="text-gray-700 text-sm">
                    Fill in the form below to reset your password.
                </p>
            </div>

            <form class="w-full p-6" method="POST" action="{{ route('password.update') }}">
                {{ csrf_field() }}

                <input type="hidden" name="token" value="{{ $token }}">

                <div class="flex flex-wrap mb-6">
                    <label for="email" class="block text-gray-700 text-sm mb-2 font-semibold">
                        Email Address
                        <span class="text-red-500 text-xs italic">*</span>
                    </label>

                    <input id="email" type="email" class="form-input w-full{{ $errors->has('email') ? ' border-red-500' : '' }}" name="email" value="{{ $email ?? old('email') }}" required autofocus>

                </div>

                <div class="flex flex-wrap mb-6">
                    <label for="password" class="block text-gray-700 text-sm mb-2 font-semibold">
                        Password
                        <span class="text-red-500 text-xs italic">*</span>
                    </label>

                    <input id="password" type="password" class="form-input w-full{{ $errors->has('password') ? ' border-red-500' : '' }}" name="password" required>
                </div>

                <div class="flex flex-wrap mb-6">
                    <label for="password-confirm" class="block text-gray-700 text-sm mb-2 font-semibold">
                        Confirm Password
                        <span class="text-red-500 text-xs italic">*</span>
                    </label>

                    <input id="password-confirm" type="password" class="form-input w-full" name="password_confirmation" required>
                </div>

                <div class="flex flex-wrap mt-16 mb-8">
                    <button type="submit" class="bg-gray-200 hover:bg-gray-300 text-gray-700 font-bold py-2 px-4 rounded text-sm">
                        Reset Password   
                        <i class="fas fa-redo-alt fa-fw"></i>
                    </button>
                </div>

                <div class="flex flex-wrap">
                    <a class="text-blue-500 hover:text-blue-700 text-sm" href="{{ route('login') }}">
                        <i class="fas fa-sign-in-alt fa-fw mr-1"></i>
                        Go to login
                    </a>
                </div>
            </form>
        </div>
    </div>

    @if ($errors->any())
        <div class="w-full max-w-md border-2 border-red-500 mt-6 rounded shadow-md">
            <div class="flex items-center bg-red-500 text-white text-sm px-4 py-3" role="alert">
                <i class="fas fa-exclamation-circle fa-fw mr-3"></i>
                <p>{{ $errors->first() }}
                    
                @if ($errors->first() === 'This password reset token is invalid.')
                    <a class="text-blue-200 hover:text-blue-300 text-sm" href="{{ route('password.request') }}">
                        Click here to request a new one.
                    </a>
                @endif
                </p>
            </div>
        </div>
    @endif

</main>

@endsection          