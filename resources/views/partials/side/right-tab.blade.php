<section class="col-span-1 flex content-center justify-center pl-16" id="right-tab">
    @guest
    <div class="h-full flex py-16 flex-col flex-grow">
        <!-- Filler -->
    </div>
    @else
    <div class="w-full flex py-16 flex-col content-center justify-start">
        <div class="flex py-2 text-xl">
            <a href="{{ url('/notifications') }}">Notifications</a>
        </div>
        <div class="flex py-2 text-xl">
            <a href="{{ url('/messages') }}">Messages</a>
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
    </div>
    @endguest
</section>