<div class="flex content-center flex-wrap justify-center w-3/4 px-2 mt-2">
    <div class="flex content-center justify-center w-full">
        <form id="search-form" class="flex content-center justify-center px-2 py-1 rounded-full group"
            action="{{ url('/search') }}" method="GET">
            <input id="search-text" class="align-middle border-b-2 dark:border-dark-secondary w-full dark:bg-dark-primary 
                focus:outline-none group-focus-within:dark:border-dark-active" type="text" name="query">
            <button
                class="align-middle border-b-2 dark:border-dark-secondary group-focus-within:dark:border-dark-active"
                type="submit">
                <i class="fas fa-search"></i>
            </button>
        </form>
    </div>
</div>