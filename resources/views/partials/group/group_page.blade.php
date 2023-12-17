@php
$type = $user_is_owner ? 'owner' : ($user_is_member ? 'member' : ($user_is_pending ? 'pending' : 'none'));
$id = ['owner' => 'settings-group', 'member' => 'leave-group', 'pending' => 'pending-group', 'none' =>
'join-group'][$type];
$icon = ['owner' => 'fa-gear', 'member' => 'fa-arrow-right-from-bracket', 'pending' => 'fa-clock-rotate-left',
'none' => 'fa-users'][$type];
$color = ['owner' => 'gray', 'member' => 'red', 'pending' => 'yellow', 'none' => 'blue'][$type];
$text = ['owner' => 'Settings', 'member' => 'Leave Group', 'pending' => 'Pending', 'none' => 'Join Group'][$type];
$width = $user_is_owner ? 'w-1/3' : 'w-1/2';
$link = $user_is_owner ? url('group/' . $group->id . '/settings') : null;

$isAdmin ??= false;
@endphp

<main id="group-page" class="   relative flex flex-col w-screen overflow-clip overflow-y-scroll h-[calc(100vh-10rem)] scrollbar-hide
                                lg:w-full lg:h-[calc(100vh-6rem)]">

    <div class="flex flex-col overflow-clip overflow-y-scroll scrollbar-hide">
        <section class="flex flex-col min-h-96 items-center justify-center gap-4 py-4" id="group-content">
            <img src="{{ $group->getPicture() }}" alt="group photo" class="w-32 h-32 rounded-full">
            <h1 class="text-2xl font-bold">{{ $group->name }}</h1>
            <div class="flex justify-start items-center w-full px-10">
                <p class="text-sm">{{ $group->description }}</p>
            </div>
            @if (!$isAdmin)
            <div class="h-16 flex w-full items-end justify-end mb-4 px-8">
                @include('partials.components.button', ['id' => $id, 'icon' => $icon, 'color' => $color, 'text' =>
                $text])
            </div>
            @endif
        </section>

        @if($user_is_member || $isAdmin)

        <div
            class="flex w-full h-12 items-center sticky -top-[1px] left-0 dark:bg-dark-primary border-b-2 dark:border-dark-neutral">
            <div id="posts"
                class="flex items-center justify-center {{ $width }} h-12 cursor-pointer dark:text-dark-active">
                <h1>Posts</h1>
            </div>
            <div id="members" class="flex items-center justify-center {{ $width }} h-12 cursor-pointer">
                <h1>Members</h1>
            </div>
            @if($user_is_owner)
            <div id="requests" class="flex items-center justify-center {{ $width }} h-12 cursor-pointer">
                <h1>Requests</h1>
            </div>
            @endif
        </div>

        <section id="posts-section" data-page="0" class="flex flex-col items-center min-h-full">
            <div class="none hidden mt-12">No posts found for this group</div>
            <div id="fetcher-posts"></div>
        </section>

        <section id="members-section" data-page="0" class="flex flex-col items-center hidden min-h-full">
            <div class="none hidden mt-12">No members found for this group</div>
            <div id="fetcher-members"></div>
        </section>

        @if($user_is_owner)
        <section id="requests-section" class="flex flex-col items-center hidden min-h-full">
            @forelse ($group->pendingMembers()->where('type', 'Request')->get() as $member)
            @include('partials.group.member', ['member' => $member, 'owner' => $user_is_owner,
            'user' => $user, 'request' => true])
            @empty
            <p class="text-center mt-12">No pending requests</p>
            @endforelse
        </section>
        @endif

        @else

        <section class="flex flex-col w-full items-center justify-center p-4 pt-16">
            <h2 class="text-lg">Seems that you are not a member yet...</h2>
            <h2 class="text-lg">Ask to join!</h2>
        </section>

        @endif
    </div>
</main>
<input type="hidden" id="group-id" value="{{ $group->id }}">