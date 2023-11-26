<div class="w-full flex flex-col content-center justify-start border border-grey-300 border-solid">
  @auth
    @if (Auth::user()->id == $user->id)
      @include('partials.profile.edit-profile')
    @else
      <div id="follow-actions" class="flex flex-row-reverse m-4">
        @php
          $follows = Auth::user()->isFollowing($user);
          $follows_class = $follows ? 'hidden' : '';
          $unfollows_class = $follows ? '' : 'hidden';
        @endphp
        <button type="submit" class="bg-gray-300 hover:bg-gray-400 text-black font-bold py-2 px-4 rounded-full mr-1 {{$unfollows_class}}">Unfollow</button>
        <button type="submit" class="bg-gray-300 hover:bg-gray-400 text-black font-bold py-2 px-4 rounded-full mr-1 {{$follows_class}}">Follow</button>
        <button type="submit" class="bg-gray-300 hover:bg-gray-400 text-black font-bold py-2 px-4 rounded-full mr-1 {{$follows_class}}">Requested to follow (Cancel)</button>
      </div>
    @endif
  @endauth
  <div class="profile-image flex flex-row justify-center mt-6">
    <img class="w-32 h-32 rounded-full" src="{{ $user->getProfilePicture() }}" alt="Profile Picture">
  </div>
  <div class="profile-info text-center mt-2"> 
    <p class="profile-name text-xl font-bold py-2">{{ $user->name }}</p> 
    <p class="profile-username text-gray-700">{{ $user->username }}</p>
    <p class="profile-description text-gray-700 py-2">{{ $user->description }}</p>
  </div>

  <div class="profile-stats flex flex-row center justify-center mt-6">
    <a href="{{ route('profile.network', $user->username) }}" class="text-center flex flex-row border-x border-gray-400 border-solid mb-1">
      <p class="p-1 profile-stat-label font-bold">Followers</p>
      <p class="p-1 profile-stat-value text-gray-600">{{ $user->followers->count() }}</p>
    </a>
    <a href="{{ route('profile.network', $user->username) }}" class="text-center flex flex-row border-r border-gray-400 border-solid">
      <p class="p-1 profile-stat-label font-bold">Following</p>
      <p class="p-1 profile-stat-value text-gray-600">{{ $user->following->count() }}</p>
    </a>
    <div class="text-center flex flex-row border-r border-gray-400 border-solid">
      <p class="p-1 profile-stat-label font-bold">Groups</p>
      <p class="p-1 profile-stat-value text-gray-600">{{ $user->groups->count() }}</p>
    </div>
  </div>
</div>
