@guest
<section class="col-span-1 flex content-center justify-center pl-16" id="notifications-tab">
    class="col-span-1 col-start-4 flex content-center justify-center pl-16 border-l border-gray-300 border-solid
    <div class="h-full flex py-16 flex-col flex-grow">
        <!-- Filler -->
    </div>
</section>
@else
<section class="col-span-1 flex content-center justify-center pl-16 border-l border-gray-300 border-solid"
    id="notifications-tab">
    <div class="w-full flex py-16 flex-col content-center">
        <div class="flex py-2 text-xl justify-center">
            <a href="{{ url('/notifications') }}">Notifications</a>
        </div>
        <div id="notifications-container" class="flex flex-col justify-center content-center py-2 text-xl">
            <div class="flex py-2 text-base text-justify">
                <a>Mary liked your post</a>
            </div>
            <div class="flex py-2 text-base text-justify">
                <a>Sam followed you</a>
            </div>
            <div class="flex py-2 text-base text-justify">
                <a>Thomas commented on your post</a>
            </div>
            <div class="flex py-2 text-base text-justify">
                <a>LEIC accepted your join request</a>
            </div>
        </div>
    </div>
</section>
@endguest