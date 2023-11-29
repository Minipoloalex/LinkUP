@php $username = Auth::user()->username; @endphp
<nav class="fixed bottom-0 left-0 z-50 w-full h-16 grid grid-cols-5 items-center px-8 bg-white border-t border-slate-400"
    id="navbar">
    <div class="flex justify-center">
        <a href="{{ route('home') }}">
            <i class="fa-solid fa-house fa-xl"></i>
        </a>
    </div>
    <div class="flex justify-center">
        <a href="{{ route('home') }}">
            <i class="fa-solid fa-search fa-xl"></i>
        </a>
    </div>
    <div class="flex justify-center">
        <i class="fa-solid fa-plus fa-xl"></i>
    </div>
    <div class="flex justify-center">
        <a href="{{ route('home') }}">
            <i class="fa-solid fa-bell fa-xl"></i>
        </a>
    </div>
    <div class="flex justify-center">
        <a href="{{ url('/profile/' . $username) }}">
            <i class="fa-solid fa-user fa-xl"></i>
        </a>
    </div>
</nav>