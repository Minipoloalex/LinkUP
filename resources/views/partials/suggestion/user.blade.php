@php
$user = App\Models\User::find($user->id);
$profile_link = route('profile.show', ['username' => $user->username]);
$pfp = $user->getProfilePicture();
if (isset($user->bio) && strlen($user->bio) > 30) $user->bio = substr($user->bio, 0, 30) . '...';
@endphp

<div class="flex items-center w-full h-14 p-1 border-t dark:border-dark-neutral first:border-0">
    <div class="h-12 min-w-[2rem] flex items-center justify-center ml-2">
        <a href="{{ $profile_link }}">
            <img src="{{ $pfp }}" alt="avatar" class="w-8 h-8 rounded-full">
        </a>
    </div>
    <a href="{{ $profile_link }}" class="flex flex-col items-start justify-center h-12 ml-2 text-xs">
        <div class="font-bold flex items-center dark:text-dark-active">
            <h2>{{ $user->username }}</h2>
        </div>
        <div>
            <h2>{{ $user->bio }}</h2>
        </div>
    </a>
</div>