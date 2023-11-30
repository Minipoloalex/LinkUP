@php
$id = ['owner' => 'settings-group', 'member' => 'leave-group', 'pending' => 'pending-group', 'none' =>
'join-group'][$type];

$icon = ['owner' => 'fas fa-gear', 'member' => 'fas fa-arrow-right-from-bracket', 'pending' => 'fas
fa-clock-rotate-left', 'none' => 'fas
fa-users'][$type];

$text = ['owner' => 'Settings', 'member' => 'Leave Group', 'pending' => 'Pending', 'none' => 'Join Group'][$type];

$bg = ['owner' => 'bg-gray-500', 'member' => 'bg-red-500', 'pending' => 'bg-yellow-500', 'none' =>
'bg-blue-500'][$type];

$bg_hover = ['owner' => 'hover:bg-gray-700', 'member' => 'hover:bg-red-600', 'pending' => 'hover:bg-yellow-700', 'none'
=> 'hover:bg-blue-700'][$type];

$class = $bg . ' ' . $bg_hover . ' ' . 'font-bold text-white py-2 px-4 rounded-full flex items-center';
$icon = $icon . ' text-base';

\Log::debug($class);
\Log::debug($icon);
\Log::debug($text);
@endphp

<button id="{{ $id }}" class="{{ $class }}">
    <i class="{{ $icon }}"></i>
    <div class="ml-4">
        {{ $text }}
    </div>
</button>