<aside class="  hidden fixed lg:flex lg:top-0 lg:right-0 lg:h-screen lg:w-[10vw] lg:border-l lg:dark:border-dark-neutral
                xl:w-[30vw] xl:pt-[9rem] xl:items-start xl:justify-start xl:pl-4">
    <div class="hidden xl:flex xl:items-start xl:justify-start xl:w-3/4">
        <div class="w-full flex flex-col items-start justify-start gap-8">
            @auth
            <div class="h-[5vh] self-center">
                @if(!request()->is('search'))
                <form id="search-home" class="flex content-center justify-center py-1 rounded-full group"
                    action="{{ url('/search') }}" method="GET">
                    <div class="rounded-full bg-gray-200 h-10 flex items-center justify-center">
                        <i class="fas fa-search text-gray-500 ml-3"></i>    
                    <input id="search-text" class="align-middle w-full bg-transparent ml-2 mr-3 text-gray-500
                    focus:outline-none" type="text" name="query" placeholder="Search"
                            autocomplete="off">
                    </div>
                    <input type="hidden" name="type" value="users">
                </form>
                @endif
            </div>
            
            <div class=" h-[30vh] w-full flex flex-col items-start justify-start border rounded-md
                    dark:border-dark-neutral z-10">
                <div class="w-full pl-4 py-1 border-b dark:border-dark-neutral">
                    <h2>Notifications</h2>
                </div>
                <div id="notifications-home-container" class="w-full overflow-clip overflow-y-scroll scrollbar-thin"
                    data-page="0">
                    <div id="notifications-home-fetcher"></div>
                </div>
            </div>
            <div class=" h-[30vh] w-full flex flex-col items-start justify-start border rounded-md 
                    dark:border-dark-neutral z-10">
                <div class="w-full pl-4 py-1 border-b dark:border-dark-neutral">
                    <h2>Suggestions</h2>
                </div>
                <div id="suggestions-home-container" class="w-full overflow-clip overflow-y-scroll scrollbar-thin"
                    data-page="0">
                    <div id="suggestions-home-fetcher"></div>
                </div>
            </div>
            @endauth
        </div>
    </div>
</aside>