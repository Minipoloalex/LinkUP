@include('partials.network.group_card', [
    'user' => $user,
    'isMyProfile' => true,
    'buttons' => [
        ['class' => 'deny-invitation', 'text' => 'Deny'],
        ['class' => 'accept-invitation', 'text' => 'Accept']
    ],
])
