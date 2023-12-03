@php $user_image = "images/users/icons/" . Auth::user()->id . ".png";
// If the user has not uploaded a profile image, use the default image
if (!file_exists($user_image)) {
$user_image = "images/users/icons/default.png";
}
@endphp
<div class="flex">
    <a class="h-12" href="{{ url('/') }}">
        <img class="w-auto h-12" src={{ $user_image }} alt="Logo">
    </a>
</div>