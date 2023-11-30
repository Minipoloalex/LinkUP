<div class="flex w-full items-center justify-between p-8 border border-slate-400">
    <a href="{{ url('profile/' . $member->username) }}">
        <div class="flex items-center justify-start">
            <img src="{{ url('images/users/icons/'. $member->id . '.jpg') }}" alt="user photo"
                class="w-16 h-16 rounded-full">
            <h1 class="text-xl pl-8">{{ $member->name }}</h1>
        </div>
    </a>
    <div class="self-end flex items-center h-full">
        @if($owner && $member->id != $user)
        {{-- If user is owner and not himself it loads remove button --}}

        @include('partials.components.button', ['id' => $member->id, 'icon' => 'fa-times', 'color' => 'red', 'text'
        => 'Remove', 'classes' => 'member-remove'])

        @endif
    </div>
</div>