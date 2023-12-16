@include('partials.network.follow_card', [
    'user' => $user,
    'isMyProfile' => $isMyProfile,
    'buttons' => [['class' => 'delete-follower', 'text' => 'Remove']],
    'linkTo' => $linkTo
])
