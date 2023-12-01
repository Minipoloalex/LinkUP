@include('partials.network.follow_card', [
    'user' => $user,
    'isMyProfile' => true,
    'buttons' => [
        ['class' => 'deny-follow-request', 'text' => 'Deny'],
        ['class' => 'accept-follow-request', 'text' => 'Accept']
    ],
])
