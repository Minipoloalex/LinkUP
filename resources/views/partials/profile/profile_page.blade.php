<main id="profile-page" class="flex flex-col w-screen
                                lg:w-full">
    <section class="flex flex-grow" id="content">
        <section class="overflow-clip overflow-y-scroll flex-grow h-full scrollbar-hide">
            @include('partials.profile.user-banner')
            @if ($userCanSeePosts)
                <div id="posts-container" data-id="{{ $user->id }}" data-page="0">
                    <div id="fetcher" class="h-16 lg:h-0">
                    </div>
                </div>
            @else
            <p class="text-center">This user has a private profile.</p>
            @endif
        </section>
    </section>
</main>