@guest

<div class="col-span-4 flex flex-wrap content-center justify-self-center">
    <a class="h-32 w-auto" href="{{ url('/') }}">
        <img class="w-auto h-32" src="{{ url('images/logo.png') }}" alt="Logo">
    </a>
</div>

@else

<div class="flex">
    <a class="h-12" href="{{ url('/') }}">
        <img class="w-auto h-12" src="{{ url('images/logo.png') }}" alt="Logo">
    </a>
</div>

@endguest