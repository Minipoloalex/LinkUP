@php
$icon = 'fas text-base ' . $icon;
$bg = 'bg-' . $color . '-500';
$bg_hover = 'hover:bg-' . $color . '-700';
$classes ??= '';
$class = $bg . ' ' . $bg_hover . ' ' . 'font-bold text-white py-2 px-4 rounded-full flex items-center ' . $classes;
@endphp

<button id="{{ $id }}" class="{{ $class }}">
    <i class="{{ $icon }}"></i>
    <div class="ml-4">
        {{ $text }}
    </div>
</button>