<section class="flex content-center justify-center mt-4">
    <div class="h-full flex flex-col flex-grow">
        <section id="search-filters">
            <ul class="flex w-full justify-between items-center text-center">
                <li class="flex gap-2 grow">
                    <input type="radio" id="users-radio" name="search-type" value="users" checked class="peer hidden">
                    <label for="users-radio" class="border-b-2 dark:border-dark-neutral
                        peer-checked:text-dark-active peer-checked:dark:border-dark-active
                        w-full text-center cursor-pointer p-4" tabindex="0">Users</label>
                </li>
                <li class="flex gap-2 grow">
                    <input type="radio" id="groups-radio" name="search-type" value="groups" class="peer hidden">
                    <label for="groups-radio" class="border-b-2 dark:border-dark-neutral
                        peer-checked:text-dark-active peer-checked:dark:border-dark-active
                        w-full text-center cursor-pointer p-4" tabindex="0">Groups</label>
                </li>
                <li class="flex gap-2 grow">
                    <input type="radio" id="posts-radio" name="search-type" value="posts" class="peer hidden">
                    <label for="posts-radio" class="border-b-2 dark:border-dark-neutral
                        peer-checked:text-dark-active peer-checked:dark:border-dark-active
                        w-full text-center cursor-pointer p-4" tabindex="0">Posts</label>
                </li>
                <li class="flex gap-2 grow">
                    <input type="radio" id="comments-radio" name="search-type" value="comments" class="peer hidden">
                    <label for="comments-radio" class="border-b-2 dark:border-dark-neutral
                        peer-checked:text-dark-active peer-checked:dark:border-dark-active
                        w-full text-center cursor-pointer p-4" tabindex="0">Comments</label>
                </li>
            </ul>
        </section>
    </div>
</section>