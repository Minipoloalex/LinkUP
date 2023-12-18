<div class="sticky top-24 left-0 flex w-screen h-12 dark:bg-dark-primary
            lg:w-full" id="timeline-tabs">
    <div id="for-you-tab" class="flex w-1/2 h-full items-center justify-center tab-active">
        <p class="font-bold"> For You </p>
    </div>
    @auth
    <div id="following-tab" class="flex w-1/2 h-full items-center justify-center">
        <p class="font-bold"> Following </p>
    </div>
    @else
    <div id="following-tab-guest" class="flex w-1/2 h-full items-center justify-center">
        <p class="font-bold"> Following </p>
    </div>
    @endauth
</div>