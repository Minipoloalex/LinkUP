@guest
<nav class="col-span-1 flex content-center justify-self-end" id="navbar">
</nav>
@else
<nav class="col-span-1 w-52 flex content-center justify-self-end border-r border-gray-300 border-solid" id="navbar">
    <div class="flex flex-col content-center justify-self-end py-16">
        <div class="flex py-2 text-xl">
            <a href="{{ url('/home') }}">Home</a>
        </div>
        <div class="flex py-2 text-xl">
            <a href="{{ route('profile.network', Auth::user()->username) }}">Network</a>
        </div>
        <div class="flex py-2 text-xl">
            <a href="{{ url('/settings') }}">Settings</a>
        </div>
        <div class="flex py-2 text-xl">
            <img class="w-8 h-8 rounded-full" src="{{ url('images/users/icons/' . Auth::user()->id . '.png') }}"
                alt="User Icon">
            <a href="{{ url('/profile/' . Auth::user()->username) }}" class="ml-3">
                {{ Auth::user()->username }}
            </a>
        </div>
    </div>
</nav>
@endguest