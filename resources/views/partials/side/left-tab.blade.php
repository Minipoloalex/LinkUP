<nav class="col-span-1 flex content-center justify-center border-r border-gray-300 border-solid" id="left-tab">
    <div class="w-full flex flex-col content-center justify-start py-16">
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
</nav>