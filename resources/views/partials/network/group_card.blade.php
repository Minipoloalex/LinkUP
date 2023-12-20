{{-- ['group' => Group object, 'user' => User object, 'buttons' => ? array] --}}
@php
$isOwner = $group->isOwner($user);
$buttons ??= null;
@endphp
@include('partials.search.group', ['group' => $group, 'linkTo' => $linkTo, 'isOwner' => $isOwner, 'buttons' => $buttons])
