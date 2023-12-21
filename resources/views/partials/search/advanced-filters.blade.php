<!-- For Users -->
<div id="user-filters" class="w-full flex flex-col gap-2 filter-selected">
    <div class="w-full flex items-start justify-start">
        <div class="text-sm flex items-center justify-end relative">
            <label for="user-exact-match" class="min-w-[25vw] lg:min-w-[10vw]">Exact
                match</label>
            <input id="user-exact-match" type="checkbox" name="exact-match"
                class="appearance-none w-4 h-4 rounded dark:bg-dark-secondary 
                                    flex items-center justify-center peer ml-2 dark:checked:bg-dark-active cursor-pointer" />
            <i class="fas fa-check absolute right-[2px] top-1 pointer-events-none"></i>
        </div>
    </div>
    @auth
    <div class="w-full flex items-start justify-start">
        <div class="text-sm flex items-center justify-end relative">
            <label for="user-filter-followers" class="min-w-[25vw] lg:min-w-[10vw]">My followers</label>
            <input id="user-filter-followers" type="checkbox" name="user-filter-followers"
                class="appearance-none w-4 h-4 rounded dark:bg-dark-secondary 
                                    flex items-center justify-center peer ml-2 dark:checked:bg-dark-active cursor-pointer" />
            <i class="fas fa-check absolute right-[2px] top-1 pointer-events-none"></i>
        </div>
    </div>
    <div class="w-full flex items-start justify-start">
        <div class="text-sm flex items-center justify-end relative">
            <label for="user-filter-following" class="min-w-[25vw] lg:min-w-[10vw]">I follow</label>
            <input id="user-filter-following" type="checkbox" name="user-filter-following"
                class="appearance-none w-4 h-4 rounded dark:bg-dark-secondary 
                                    flex items-center justify-center peer ml-2 dark:checked:bg-dark-active cursor-pointer" />
            <i class="fas fa-check absolute right-[2px] top-1 pointer-events-none"></i>
        </div>
    </div>
    @endauth
</div>

<!-- For Groups -->
<div id="group-filters" class="w-full flex flex-col gap-2 hidden">
    <div class="w-full flex items-start justify-start">
        <div class="text-sm flex items-center justify-end relative">
            <label for="group-exact-match" class="min-w-[25vw] lg:min-w-[10vw]">Exact
                match</label>
            <input id="group-exact-match" type="checkbox" name="exact-match"
                class="appearance-none w-4 h-4 rounded dark:bg-dark-secondary 
                                    flex items-center justify-center peer ml-2 dark:checked:bg-dark-active cursor-pointer" />
            <i class="fas fa-check absolute right-[2px] top-1 pointer-events-none"></i>
        </div>
    </div>
    @auth
    <div class="w-full flex items-start justify-start">
        <div class="text-sm flex items-center justify-end relative">
            <label for="group-filter-owner" class="min-w-[25vw] lg:min-w-[10vw]">Owned by me</label>
            <input id="group-filter-owner" type="checkbox" name="group-filter-owner"
                class="appearance-none w-4 h-4 rounded dark:bg-dark-secondary 
                                    flex items-center justify-center peer ml-2 dark:checked:bg-dark-active cursor-pointer" />
            <i class="fas fa-check absolute right-[2px] top-1 pointer-events-none"></i>
        </div>
    </div>
    <div class="w-full flex items-start justify-start">
        <div class="text-sm flex items-center justify-end relative">
            <label for="group-filter-not-owner" class="min-w-[25vw] lg:min-w-[10vw]">Not a member</label>
            <input id="group-filter-not-owner" type="checkbox" name="group-filter-not-member"
                class="appearance-none w-4 h-4 rounded dark:bg-dark-secondary 
                                    flex items-center justify-center peer ml-2 dark:checked:bg-dark-active cursor-pointer" />
            <i class="fas fa-check absolute right-[2px] top-1 pointer-events-none"></i>
        </div>
    </div>
    @endauth
</div>

<!-- For Posts -->
<div id="post-filters" class="w-full flex flex-col gap-2 hidden">
    @auth
    <div class="w-full flex items-start justify-start">
        <div class="text-sm flex items-center justify-end relative">
            <label for="post-filter-likes" class="min-w-[25vw] lg:min-w-[10vw]">I liked</label>
            <input id="post-filter-likes" type="checkbox" name="post-filter-likes"
                class="appearance-none w-4 h-4 rounded dark:bg-dark-secondary 
                                    flex items-center justify-center peer ml-2 dark:checked:bg-dark-active cursor-pointer" />
            <i class="fas fa-check absolute right-[2px] top-1 pointer-events-none"></i>
        </div>
    </div>
    <div class="w-full flex items-start justify-start">
        <div class="text-sm flex items-center justify-end relative">
            <label for="post-filter-comments" class="min-w-[25vw] lg:min-w-[10vw]">I commented</label>
            <input id="post-filter-comments" type="checkbox" name="post-filter-comments"
                class="appearance-none w-4 h-4 rounded dark:bg-dark-secondary 
                                    flex items-center justify-center peer ml-2 dark:checked:bg-dark-active cursor-pointer" />
            <i class="fas fa-check absolute right-[2px] top-1 pointer-events-none"></i>
        </div>
    </div>
    @endauth
    <div class="w-full flex items-start justify-start">
        <div class="text-sm flex items-center justify-end relative">
            <label for="post-filter-date" class="min-w-[25vw] lg:min-w-[10vw]">Before date</label>
            <input id="post-filter-date" type="date" name="post-filter-date"
                class="text-black">
        </div>
    </div>
</div>

<!-- For Comments -->
<div id="comment-filters" class="w-full flex flex-col gap-2 hidden">
    @auth
    <div class="w-full flex items-start justify-start">
        <div class="text-sm flex items-center justify-end relative">
            <label for="comment-filter-likes" class="min-w-[25vw] lg:min-w-[10vw]">I liked</label>
            <input id="comment-filter-likes" type="checkbox" name="post-filter-likes"
                class="appearance-none w-4 h-4 rounded dark:bg-dark-secondary 
                                    flex items-center justify-center peer ml-2 dark:checked:bg-dark-active cursor-pointer" />
            <i class="fas fa-check absolute right-[2px] top-1 pointer-events-none"></i>
        </div>
    </div>
    <div class="w-full flex items-start justify-start">
        <div class="text-sm flex items-center justify-end relative">
            <label for="comment-filter-comments" class="min-w-[25vw] lg:min-w-[10vw]">I commented</label>
            <input id="comment-filter-comments" type="checkbox" name="post-filter-comments"
                class="appearance-none w-4 h-4 rounded dark:bg-dark-secondary 
                                    flex items-center justify-center peer ml-2 dark:checked:bg-dark-active cursor-pointer" />
            <i class="fas fa-check absolute right-[2px] top-1 pointer-events-none"></i>
        </div>
    </div>
    @endauth
    <div class="w-full flex items-start justify-start">
        <div class="text-sm flex items-center justify-end relative">
            <label for="comment-filter-date" class="min-w-[25vw] lg:min-w-[10vw]">Before date</label>
            <input id="comment-filter-date" type="date" name="post-filter-date"
                class="text-black"/>
        </div>
    </div>
</div>