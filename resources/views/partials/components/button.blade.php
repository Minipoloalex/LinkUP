@php
$icon = 'fas text-base ' . $icon;
$bg = 'bg-' . $color;
$bg_hover = 'hover:bg-' . $color . '-700';
$classes ??= '';
$class = $bg . ' ' . $bg_hover . ' ';
$class = $class . 'font-bold text-white py-2 px-4 rounded-full flex items-center justify-center';
$data ??= null;
$dataset = [];
if ($data) {
foreach ($data as $key => $value) {
$dataset[] = 'data-' . $key . '=' . $value;
}
}
$dataset = implode(' ', $dataset);
@endphp

<button id="{{ $id }}" class="{{ $class }} {{ $classes }}" {{ $dataset }}>
    <a href="{{ $link }}" class="flex items-center justify-center">
        <i class="{{ $icon }}"></i>
        @if ($text)
        <span class="button-text ml-4">
            {{ $text }}
        </span>
        @endif
    </a>
</button>