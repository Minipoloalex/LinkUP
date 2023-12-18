<aside class="  hidden fixed lg:flex lg:top-0 lg:right-0 lg:h-screen lg:w-[10vw] lg:border-l lg:dark:border-dark-neutral
                xl:w-[30vw] xl:pt-[9rem] xl:items-start xl:justify-start xl:pl-4">
    <div class="hidden xl:flex xl:items-start xl:justify-start xl:w-3/4">
        <div class="w-full flex flex-col items-start justify-start gap-8">
            @auth
            <div class="h-[5vh] w-full">
                @if(!request()->is('search'))
                <form id="search-home" class="flex content-center justify-center py-1 rounded-full group"
                    action="{{ url('/search') }}" method="GET">

                    <input id="search-text" class="align-middle border-b-2 dark:border-dark-secondary w-full dark:bg-dark-primary 
                focus:outline-none group-focus-within:dark:border-dark-active" type="text" name="query"
                        autocomplete="off">
                    <input type="hidden" name="type" value="users">
                    <button
                        class="align-middle border-b-2 dark:border-dark-secondary group-focus-within:dark:border-dark-active text-2xl"
                        type="submit">
                        <i class="fas fa-search mr-2"></i>
                    </button>

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