@include('partials.network.follow_card', [
    'user' => $user,
    'editable' => true,
    'buttons' => [
        ['class' => 'deny-follow-request', 'text' => 'Deny'],
        ['class' => 'accept-follow-request', 'text' => 'Accept']
    ],
])
