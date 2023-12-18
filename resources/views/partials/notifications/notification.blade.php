@if ($notification->getType() == 'comment')
@include('partials.notifications.comment')
@elseif ($notification->getType() == 'like')
@include('partials.notifications.like')
@elseif ($notification->getType() == 'group')
@include('partials.notifications.group')
@elseif ($notification->getType() == 'follow-request')
@include('partials.notifications.follow-request')
@endif