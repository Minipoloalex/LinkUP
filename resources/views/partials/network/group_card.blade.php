{{-- ['group' => Group object, 'user' => User object] --}}
@php
$isOwner = $group->isOwner($user);
@endphp
@include('partials.search.group', ['group' => $group, 'linkTo' => $linkTo, 'isOwner' => $isOwner])