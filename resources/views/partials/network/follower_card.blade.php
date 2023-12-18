@php
$linkTo ??= route('profile.show', ['username' => $user->username]);
@endphp
@include('partials.network.follow_card', [
'user' => $user,
'isMyProfile' => $isMyProfile,
'buttons' => [['class' => 'delete-follower', 'text' => 'Remove']],
'linkTo' => $linkTo
])