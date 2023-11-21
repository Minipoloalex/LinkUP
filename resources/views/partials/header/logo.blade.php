@guest

<div class="col-span-4 flex flex-wrap content-center justify-self-center">
    <a class="h-32 w-auto" href="{{ url('/') }}">
        <img class="w-auto h-32" src="{{ url('images/logo.png') }}" alt="Logo">
    </a>
</div>

@else

<div class="col-span-1 w-52 flex flex-wrap content-center justify-self-end border-gray-300 border-solid border-r">
    <a class="h-24" href="{{ url('/') }}">
        <img class="w-auto h-24" src="{{ url('images/logo.png') }}" alt="Logo">
    </a>
</div>

@endguest