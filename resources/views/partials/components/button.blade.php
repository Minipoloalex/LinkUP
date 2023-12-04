@php
$icon = 'fas text-base ' . $icon;
$bg = 'bg-' . $color . '-500';
$bg_hover = 'hover:bg-' . $color . '-700';
$classes ??= '';
$link ??= '';
$class = $bg . ' ' . $bg_hover . ' ';
$class = $class . 'font-bold text-white py-2 px-4 rounded-full flex items-center justify-center
' .
$classes;
@endphp

<button id="{{ $id }}" class="{{ $class }}">
    @if ($link)
    <a href="{{ $link }}" class="flex items-center justify-center">
        @endif
        <i class="{{ $icon }}"></i>
        @if ($text)
        <div class="ml-4">
            {{ $text }}
        </div>
        @endif
        @if ($link)
    </a>
    @endif
</button>