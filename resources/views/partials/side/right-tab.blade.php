<aside class="  hidden fixed md:flex md:top-0 md:right-0 md:h-screen md:w-[10vw] md:border-l md:dark:border-dark-neutral
                lg:w-[30vw] lg:pt-[9rem] lg:items-start lg:justify-start lg:pl-4">
    <div class="hidden lg:flex lg:items-start lg:justify-start lg:w-3/4">
        <div class="w-full flex flex-col items-start justify-start gap-8">
            <div class="h-[5vh] w-full">
                <form id="search-form" class="flex content-center justify-center py-1 rounded-full group"
                    action="{{ url('/search') }}" method="GET">
                    <input id="search-text" class="align-middle border-b-2 dark:border-dark-secondary w-full dark:bg-dark-primary 
                focus:outline-none group-focus-within:dark:border-dark-active" type="text" name="query">
                    <button
                        class="align-middle border-b-2 dark:border-dark-secondary group-focus-within:dark:border-dark-active text-2xl"
                        type="submit">
                        <i class="fas fa-search mr-2"></i>
                    </button>
                </form>
            </div>
            <div class=" h-[30vh] w-full flex flex-col items-start justify-start pl-5 border rounded-md 
                    dark:border-dark-neutral z-10">
                Notifications
            </div>
            <div class=" h-[30vh] w-full flex flex-col items-start justify-start pl-5 border rounded-md 
                    dark:border-dark-neutral z-10">
                Suggestions
            </div>
        </div>
    </div>
</aside>