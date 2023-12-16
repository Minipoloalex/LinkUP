@php
$isMyProfile = Auth::check() && Auth::user()->id == $user->id;
$isAdmin = Auth::guard('admin')->check();
$userLinkTo = $isAdmin ? route('admin.user', ['username' => $user->username])
                    : route('profile.show', ['username' => $user->username]);
$groupLinkTo = $isAdmin ? 'admin.group' : 'group.show';
@endphp
<main id="network-page" class=" relative flex flex-col w-screen overflow-clip overflow-y-scroll h-[calc(100vh-10rem)]
                                lg:w-full lg:h-[calc(100vh-6rem)]">
    <section class="flex overflow-clip overflow-y-auto scrollbar-hide" id="content">
        <section id="network" class="flex flex-col flex-grow w-full h-min">
            <header class="flex flex-row justify-around sticky top-0 left-0 dark:bg-dark-primary">
                <button id="followers-button" class="w-full p-2 border-2 active after:content-['_Followers']">{{
                    $user->followers->count() }}</button>
                <button id="following-button" class="w-full p-2 border-y-2 border-r-2 after:content-['_Following']">{{
                    $user->following->count() }}</button>
                @if ($isMyProfile)
                <button id="follow-requests-button" class="w-full p-2 border-y-2 border-r-2 after:content-['_Requests']">{{
                    $user->followRequestsReceived->count() }}</button>
                @endif
                <button id="groups-button" class="w-full p-2 border-y-2 after:content-['_Groups']">{{
                    $user->groups->count() }}</button>
            </header>
            <div id="followers-list" class="flex flex-col">
                @forelse ($user->followers as $follower)
                @include('partials.network.follower_card', [
                    'user' => $follower,
                    'isMyProfile' => $isMyProfile,
                    'linkTo' => $userLinkTo,
                ])
                @empty
                @if ($isMyProfile)
                <p class="empty-list">You have no followers</p>
                @else
                <p class="empty-list">{{$user->username}} has no followers</p>
                @endif
                @endforelse
            </div>
            <div id="following-list" class="flex flex-col hidden">
                @forelse ($user->following as $following)
                @include('partials.network.following_card', [
                'user' => $following,
                'isMyProfile' => $isMyProfile,
                'linkTo' => $userLinkTo,
                ])
                @empty
                @if ($isMyProfile)
                <p class="empty-list">You are not following anyone</p>
                @else
                <p class="empty-list">{{ $user->username }} is not following anyone</p>
                @endif
                @endforelse
            </div>
            @if ($isMyProfile)
            <div id="follow-requests-list" class="flex flex-col hidden">
                @forelse ($user->followRequestsReceived as $followRequest)
                @include('partials.network.follow_request_card', [
                'user' => $followRequest->userRequesting,
                'linkTo' => $userLinkTo,
                ])
                @empty
                <p class="empty-list">You have received no follow requests</p>
                @endforelse
            </div>
            @endif
            <div id="groups-list" class="flex flex-col gap-2 hidden">
                @forelse ($user->groups as $groupMember)
                @php
                $group = $groupMember->group;
                @endphp
                @include('partials.network.group_card', [
                    'group' => $group,
                    'linkTo' => route($groupLinkTo, ['id' => $group->id]),
                ])
                @empty
                <p class="empty-list">You are not a member of any group</p>
                @endforelse
                @if ($isMyProfile)
                <a href="{{ route('group.create') }}"
                    class="flex items-center justify-center w-full h-10 px-4 py-2 mt-4 text-sm font-medium">
                    Create a group
                </a>
                @endif
            </div>
        </section>
    </section>
</main>