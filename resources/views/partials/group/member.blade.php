@php
$request ??= false;
$linkTo = Auth::guard('admin')->check() ? url("/admin/profile/$member->username") : url("/profile/$member->username");
@endphp

<div class="group-member flex w-full items-center justify-between p-8 border border-slate-400">
    <a href="{{ $linkTo }}">
        <div class="flex items-center justify-start">
            <img src="{{ $member->getProfilePicture() }}" alt="user photo"
                class="w-16 h-16 rounded-full">
            <h1 class="text-xl pl-8">{{ $member->name }}</h1>
        </div>
    </a>
    <div class="self-end flex items-center h-full">
        @if($owner && $member->id !== $user)

        @if($request)
        {{-- If request is set we want buttons to accept or reject the request --}}

        @include('partials.components.button', ['id' => 'a' . $member->id, 'icon' => 'fa-check', 'color' => 'green',
        'text' => null, 'classes' => 'member-accept mr-4 w-12'])
        @include('partials.components.button', ['id' => 'r' . $member->id, 'icon' => 'fa-times', 'color' => 'red',
        'text' => null, 'classes' => 'member-reject w-12'])

        @else
        {{-- If user is owner and not himself it loads remove button --}}

        @include('partials.components.button', ['id' => $member->id, 'icon' => 'fa-times', 'color' => 'red',
        'text'
        => 'Remove', 'classes' => 'member-remove'])

        @endif

        @endif
    </div>
</div>