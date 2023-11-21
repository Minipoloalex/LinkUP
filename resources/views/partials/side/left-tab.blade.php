<nav class="col-span-1 flex content-center justify-self-end" id="left-tab">
    @guest
    @else
    <div class="flex flex-col content-center justify-self-end py-16">
        <div class="flex py-2 text-xl">
            <a href="{{ url('/home') }}">Home</a>
        </div>
        <div class="flex py-2 text-xl">
            <a href="{{ url('/profile') }}">Profile</a>
        </div>
        <div class="flex py-2 text-xl">
            <a href="{{ url('/friends') }}">Friends</a>
        </div>
        <div class="flex py-2 text-xl">
            <a href="{{ url('/groups') }}">Groups</a>
        </div>
        <div class="flex py-2 text-xl">
            <a href="{{ url('/events') }}">Events</a>
        </div>
        <div class="flex py-2 text-xl">
            <a href="{{ url('/settings') }}">Settings</a>
        </div>
    </div>
    @endguest
</nav>