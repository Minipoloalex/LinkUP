<aside class="  hidden fixed lg:flex lg:top-0 lg:right-0 lg:h-screen lg:w-[10vw] lg:border-l lg:dark:border-dark-neutral
                xl:w-[30vw] xl:pt-[9rem] xl:items-start xl:justify-start xl:pl-4">
    <div class="hidden xl:flex xl:items-start xl:justify-start xl:w-3/4">
        <div class="w-full flex flex-col items-start justify-start gap-8">
            @auth
            <div class="h-[5vh] self-center">
                @if(!request()->is('search'))
                <form id="search-home" class="flex content-center justify-center py-1 rounded-full group"
                    action="{{ url('/search') }}" method="GET">
                    <div
                        class="rounded-full bg-transparent h-10 flex items-center justify-center border-2 border-dark-active">
                        <button type="submit"><i class="fas fa-search text-white ml-3"></i></button>
                        <input id="search-text" class="align-middle w-full bg-transparent ml-2 mr-3 text-white font-normal text-sm
                    focus:outline-none" type="text" name="query" placeholder="Search" autocomplete="off">
                    </div>
                    <input type="hidden" name="type" value="users">
                </form>
                @endif
            </div>

            <div id="notifications-tab"
                class=" h-[30vh] w-full flex flex-col items-center justify-start mt-8 mb-4 z-10 rounded-md">
                <a href="{{ route('notifications') }}" class="w-3/4 pl-4 py-3 border-b-2 dark:border-dark-active ">
                    <h2><i class="fas fa-bell mr-2"></i>Notifications</h2>
                </a>
                <div id="notifications-home-container"
                    class="w-3/4 overflow-clip overflow-y-scroll scrollbar-hide border dark:border-dark-neutral"
                    data-page="0">
                    <div id="notifications-home-fetcher"></div>
                </div>
            </div>
            <div class=" h-[30vh] w-full flex flex-col items-center justify-start z-10">
                <div class="w-3/4 pl-4 py-3 border-b-2 dark:border-dark-active">
                    <h2><i class="fas fa-users mr-2"></i>Suggestions</h2>
                </div>
                <div id="suggestions-home-container"
                    class="w-3/4 overflow-clip overflow-y-scroll scrollbar-hide border dark:border-dark-neutral"
                    data-page="0">
                    <div id="suggestions-home-fetcher"></div>
                </div>
            </div>
            @endauth
        </div>
    </div>
</aside>