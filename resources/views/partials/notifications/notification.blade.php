<div class="border border-slate-400 w-full min-h-24 flex px-10">
    @if ($notification->getType() == 'comment')
    @include('partials.notifications.comment')
    @elseif ($notification->getType() == 'like')
    @include('partials.notifications.like')
    @elseif ($notification->getType() == 'group')
    @include('partials.notifications.group')
    @elseif ($notification->getType() == 'follow-request')
    @include('partials.notifications.follow-request')
    @endif
</div>