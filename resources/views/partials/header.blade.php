<header class="grid grid-cols-4 absolute top-0 left-0 h-32 w-screen px-64">
    @guest

    @include('partials.header.logo')

    @else

    @include('partials.header.logo')
    @include('partials.header.search-bar')
    @include('partials.header.logout')

    @endguest
</header>