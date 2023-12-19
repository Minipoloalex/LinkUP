@php
$type = $user_is_owner ? 'owner' : ($user_is_member ? 'member' : ($user_is_pending ? 'pending' : 'none'));
$id = ['owner' => 'settings-group', 'member' => 'leave-group', 'pending' => 'pending-group', 'none' =>
'join-group'][$type];
$color = ['owner' => 'dark-neutral', 'member' => 'dark-active', 'pending' => 'dark-neutral', 'none' =>
'dark-active'][$type];
$text = ['owner' => 'Settings', 'member' => 'Leave Group', 'pending' => 'Pending', 'none' => 'Join Group'][$type];
$width = $user_is_owner ? 'w-1/3' : 'w-1/2';
$link = $user_is_owner ? url('group/' . $group->id . '/settings') : null;

$isAdmin ??= false;
$owner = $group->owner;
$userLinkTo = $isAdmin ? route('admin.user', $owner->username) : route('profile.show', $owner->username);
@endphp

<main id="group-page" class="   relative flex flex-col w-screen overflow-clip overflow-y-scroll h-[calc(100vh-10rem)] scrollbar-hide
                                lg:w-full lg:h-[calc(100vh-6rem)]">

    <div class="flex flex-col overflow-clip overflow-y-scroll scrollbar-hide">
        <section class="flex flex-col min-h-96 items-center justify-center gap-4 py-4" id="group-content">
            <img src="{{ $group->getPicture() }}" alt="group photo" class="w-32 h-32 rounded-full">
            <h1 class="text-2xl font-bold">{{ $group->name }}</h1>
            <div class="flex flex-col justify-center items-start w-full px-10">
                <p class="text-sm">{{ $group->description }}</p>
                <a href="{{ $userLinkTo }}" class="text-sm before:content-['Owner:_']">{{ $group->owner->username }}</a>
            </div>
            @if (!$isAdmin)
            <div class="h-10 flex w-full items-center justify-end mb-4 px-8">
                <button id="{{ $id }}"
                    class="follow-accept h-8 w-32 rounded-full dark:bg-{{ $color }} flex items-center justify-center px-4 text-sm">
                    @if ($link)
                    <a href="{{ $link }}" class="button-text">{{ $text }}</a>
                    @else
                    <span class="button-text">{{ $text }}</span>
                    @endif
                </button>
            </div>
            @endif
        </section>

        @if($user_is_member || $isAdmin)

        <div
            class="flex w-full h-12 items-center sticky -top-[1px] left-0 dark:bg-dark-primary">
            <button id="posts"
                class="flex items-center justify-center {{ $width }} h-12 cursor-pointer
                border-b-2 dark:border-dark-neutral tab-active">
                <h3>Posts</h3>
            </button>
            <button id="members"
                class="flex items-center justify-center {{ $width }} h-12 cursor-pointer
                border-b-2 dark:border-dark-neutral">
                <h3>Members</h3>
            </button>
            @if($user_is_owner)
            <button id="requests"
                class="flex items-center justify-center {{ $width }} h-12 cursor-pointer border-b-2
                border-b-2 dark:border-dark-neutral">
                <h3>Requests</h3>
            </button>
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
            'user' => $member, 'request' => true])
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