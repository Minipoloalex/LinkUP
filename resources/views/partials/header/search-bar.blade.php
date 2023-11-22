<div class="col-span-2 flex content-center flex-wrap justify-center flex-grow">
    <div class="w-9/12 flex content-center justify-center flex-grow">
        <form id="search-form" class="flex flex-row content-center justify-center mb-0 border-gray-300 border-solid border
                             px-2 py-1 rounded-full" action="{{ url('/search') }}" method="GET">
            <input id="search-text" class="align-middle border-0 focus:outline-none" type="text" name="query">
            <button class="align-middle" type="submit">
                <img class="w-6 h-6" src="{{ url('images/search.png') }}" alt="Search">
            </button>
        </form>
    </div>
</div>