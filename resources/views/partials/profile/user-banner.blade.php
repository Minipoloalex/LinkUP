<div class="w-full flex flex-col content-center justify-start border border-grey-300 border-solid">

  @include('partials.profile.edit-profile')
  <div class="profile-image flex flex-row justify-center mt-6">
    <img class="w-32 h-32 rounded-full" src="{{ $user->getProfilePicture() }}" alt="Profile Picture">
  </div>
  <div class="profile-info text-center mt-2"> 
    <p class="profile-name text-xl font-bold py-2">{{ $user->name }}</p> 
    <p class="profile-username text-gray-700">{{ $user->username }}</p>
    <p class="profile-description text-gray-700 py-2">{{ $user->description }}</p>
  </div>

  <div class="profile-stats flex flex-row center justify-center mt-6">
    <div class="text-center flex flex-row border-r border-gray-400 border-solid mb-1">
      <p class="profile-stat-label font-bold mr-1 ">Followers</p>
      <p class="profile-stat-value text-gray-600 mr-1">{{ $user->followers->count() }}</p>
    </div>
    <div class="text-center flex flex-row border-r border-gray-400 border-solid">
      <p class="profile-stat-label font-bold  mr-1 ">Following</p>
      <p class="profile-stat-value text-gray-600 mr-1">{{ $user->following->count() }}</p>
    </div>
    <div class="text-center flex flex-row border-r border-gray-400 border-solid">
      <p class="profile-stat-label font-bold mr-1 ">Groups</p>
      <p class="profile-stat-value text-gray-600 mr-1">{{ $user->groups->count() }}</p>
    </div>
  </div>

</div>
