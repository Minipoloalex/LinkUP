<div class="flex w-full items-center justify-start p-8 border border-slate-400">
    <a href="{{ url('profile/' . $member->username) }}" class="w-full">
        <div class="flex w-full items-center justify-start">
            <img src="{{ url('images/users/icons/'. $member->id . '.jpg') }}" alt="user photo"
                class="w-16 h-16 rounded-full">
            <h1 class="text-xl pl-8">{{ $member->name }}</h1>
        </div>
    </a>
</div>