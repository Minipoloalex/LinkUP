<div class="flex content-center justify-start flex-wrap col-span-1 border-gray-300 border-solid border-l pl-16">
    <div>
        @guest
        <a href="{{ url('/login') }}">Login</a>
        @else
        <a href="{{ route('profile.show', ['username' => Auth::user()->username]) }}">
            <img class="w-8 h-8" src="{{ url('images/profile.png') }}" alt="Profile">
        </a>
        <a href="{{ url('/logout') }}">Logout</a>
        @endguest
    </div>
</div>