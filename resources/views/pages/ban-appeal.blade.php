@extends('layouts.auth')

@section('title', 'Ban Appeal')
@section('content')

<section id="ban-appeal" class="flex flex-col items-center justify-center w-full mt-16">
    <div class="rounded-lg shadow-md text-left max-w-xl w-full border-2 border-dark-active p-8">
        <h1 class="text-2xl font-bold mb-8">Appeal a Ban</h1>
        
        <div class="pt-4 p-8">
            <form>
                {{ csrf_field() }}

                <div class="mb-8">
                    <label for="username" class="block text-regular mb-2">Username</label>
                    <input type="text" name="username" id="username" class="border-b border-dark-active text-sm w-full py-2 px-3 bg-transparent focus:outline-none"  
                    value="{{ old('username') }}" required autofocus>
                </div>

                <div class="mb-4">
                    <label for="reason" class="block text-regular mb-2">Reason</label>
                    <p class="text-xs mb-4 text-gray-300">Please explain why you think you should be unbanned.</p>
                    <textarea name="reason" id="reason" cols="30" rows="5" class="border border-dark-active rounded-md py-2 px-3 w-full text-sm bg-transparent resize-none focus:outline-none focus:shadow-outline" 
                    required>{{ old('reason') }}</textarea>
                </div>

                <button type="submit" class="bg-dark-active text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline float-right">Submit</button>
            </form>
        </div>
    </div>
</section>
@endsection