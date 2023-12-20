@php
$request ??= false;
$linkTo = Auth::guard('admin')->check() ? url("/admin/profile/$member->username") : url("/profile/$member->username");
@endphp

<div class="group-member flex w-full items-center justify-between p-8 border border-slate-400">
    <a href="{{ $linkTo }}">
        <div class="flex items-center justify-start">
            <img src="{{ $member->getProfilePicture() }}" alt="user photo" class="w-16 h-16 rounded-full">
            <h1 class="text-xl pl-8">{{ $member->name }}</h1>
        </div>
    </a>
    <div class="self-end flex items-center h-full gap-2">
        @if($owner && $member->id !== $user)

        @if($request)
        {{-- If request is set we want buttons to accept or reject the request --}}

        <button id="a{{ $member->id }}" class="member-accept w-8 h-8 rounded-full dark:bg-dark-active"
            data-user="{{ $member->id }}">
            <i class="fa-solid fa-check"></i>
        </button>
        <button id="r{{ $member->id }}" class="member-reject w-8 h-8 rounded-full dark:bg-dark-neutral"
            data-user="{{ $member->id }}">
            <i class="fa-solid fa-times"></i>
        </button>

        @else
        {{-- If user is owner and not himself it loads remove button --}}

        <div class="flex flex-grow items-center justify-end gap-2">
            <button id="{{ $member->id }}" class="member-remove w-8 h-8 rounded-full dark:bg-dark-active"
                data-user="{{ $member->id }}">
                <i class="fa-solid fa-times"></i>
            </button>
        </div>
        @endif

        @endif
    </div>
</div>