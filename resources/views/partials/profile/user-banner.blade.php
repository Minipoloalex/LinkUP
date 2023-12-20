@php
$isAdmin = Auth::guard('admin')->check();
function getNetworkLink($isAdmin, $username, $section) {
if ($isAdmin) {
return route('admin.user.network', ['username' => $username, 'section' => $section]);
}
return route('profile.network', ['username' => $username, 'section' => $section]);
}
@endphp
<div class="w-full flex flex-col content-center justify-start border-b dark:border-dark-neutral">
    @auth
    @if ($followRequest)
    <div id="follow-request-profile" class="w-full flex items-center justify-center px-4 py-1">
        <span class="text-sm">{{ $followRequest->username }} has requested to follow you.</span>
        <div class="flex flex-grow items-center justify-end gap-2">
            <button id="fa{{ $user->id }}" class="follow-accept w-6 h-6 rounded-full dark:bg-dark-active"
                data-user="{{ $user->id }}">
                <i class="fa-solid fa-check"></i>
            </button>
            <button id="fr{{ $user->id }}" class="follow-reject w-6 h-6 rounded-full dark:bg-dark-neutral"
                data-user="{{ $user->id }}">
                <i class="fa-solid fa-times"></i>
            </button>
        </div>
    </div>
    @endif
    @if (Auth::user()->id == $user->id)
    <div id="edit-profile" class="flex flex-row-reverse m-4">
        <a href="{{ route('profile.edit') }}"
            class="bg-gray-300 hover:bg-gray-400 text-black font-bold py-2 px-4 rounded-full mr-1">
            <i class="fa-solid fa-pen-to-square"></i>
        </a>
    </div>
    @elseif (!$isAdmin)
    <div id="follow-actions" class="flex flex-row-reverse m-4">
        @php
        $follows = Auth::user()->isFollowing($user);
        $pending = Auth::user()->requestedToFollow($user);

        $follows_button = !$pending && !$follows ? '' : 'hidden';
        $sent_button = $pending ? '' : 'hidden';
        $unfollows_button = $follows ? '' : 'hidden';
        @endphp
        <button id="unfollow" data-id="{{ $user->id }}" type="submit"
            class="bg-gray-300 hover:bg-gray-400 text-black font-bold py-2 px-4 rounded-full mr-1 {{$unfollows_button}}">Unfollow</button>
        <button id="request-follow" data-id="{{ $user->id }}" type="submit"
            class="bg-gray-300 hover:bg-gray-400 text-black font-bold py-2 px-4 rounded-full mr-1 {{$follows_button}}">Follow</button>
        <button id="sent-follow" data-id="{{ $user->id }}" type="submit"
            class="bg-gray-300 hover:bg-gray-400 text-black font-bold py-2 px-4 rounded-full mr-1 {{$sent_button}}">Requested
            to follow (Cancel)</button>
    </div>
    @endif
    @endauth
    <div class="profile-image flex flex-row justify-center mt-6">
        <img class="w-32 h-32 rounded-full" src="{{ $user->getProfilePicture() }}" alt="Profile Picture">
    </div>
    <div class="profile-info text-center mt-2">
        <p class="profile-name text-2xl font-bold">{{ $user->name }}</p>
        <p class="profile-username mb-4">
            {{ '@' . $user->username }}
            @if ($user->is_private)
            <i class="fa-solid fa-lock"></i>
            @endif
        </p>

        <p class="mb-4">
            @if ($user->faculty) <i class="fa-solid fa-university"></i> @endif
            {{ $user->faculty }}
            @if ($user->course) <i class="fa-solid fa-graduation-cap"></i> @endif
            {{ $user->course }}
        </p>

        <p class="profile-bio">{{ $user->bio }}</p>
    </div>

    <div class="profile-stats flex flex-row center justify-between px-4 mt-6">
        <a href="{{ getNetworkLink($isAdmin, $user->username, 'followers') }}"
            class="text-center flex flex-row  border-gray-400 border-solid mb-1">
            <p class="p-1 profile-stat-label font-bold">Followers</p>
            <p class="p-1 profile-stat-value">{{ $user->followers->count() }}</p>
        </a>
        <a href="{{ getNetworkLink($isAdmin, $user->username, 'following') }}"
            class="text-center flex flex-row border-gray-400 border-solid">
            <p class="p-1 profile-stat-label font-bold">Following</p>
            <p id="following-number" class="p-1 profile-stat-value">{{ $user->following->count() }}</p>
        </a>
        <a href="{{ getNetworkLink($isAdmin, $user->username, 'groups') }}"
            class="text-center flex flex-row border-gray-400 border-solid">
            <p class="p-1 profile-stat-label font-bold">Groups</p>
            <p class="p-1 profile-stat-value">{{ $user->groups->count() }}</p>
        </a>
    </div>
</div>