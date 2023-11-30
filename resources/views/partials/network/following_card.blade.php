@include('partials.network.follow_card', [
    'user' => $user,
    'editable' => $editable,
    'buttons' => [['class' => 'delete-following', 'text' => 'Unfollow']],
])
