<header class="grid grid-cols-4 absolute top-0 left-0 h-32 w-screen px-64">
    @guest

    @include('partials.header.logo')
    <a class="col-start-4 row-start-1 absolute top-0 right-0 h-32 mx-20 my-10" href="{{ url('/login') }}">Login</a>

    @else

    @include('partials.header.logo')
    @include('partials.header.search-bar')
    @include('partials.header.logout')

    @endguest
</header>