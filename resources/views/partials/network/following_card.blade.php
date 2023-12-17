@include('partials.network.follow_card', [
    'user' => $user,
    'isMyProfile' => $isMyProfile,
    'buttons' => [['class' => 'delete-following', 'text' => 'Unfollow']],
    'linkTo' => $linkTo
])
