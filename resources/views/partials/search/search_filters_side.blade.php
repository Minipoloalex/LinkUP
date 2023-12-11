<section class="flex content-center justify-center mt-2">
    <div class="h-full flex flex-col flex-grow">
        <section id="search-filters">
            <ul class="flex gap-2 w-full px-8 justify-between items-center">
                <li class="flex gap-2">
                    <input type="radio" id="users-radio" name="search-type" value="users" checked class="peer hidden">
                    <label for="users-radio" class="peer-checked:text-dark-active">Users</label>
                </li>
                <li class="flex gap-2">
                    <input type="radio" id="groups-radio" name="search-type" value="groups" class="peer hidden">
                    <label for="groups-radio" class="peer-checked:text-dark-active">Groups</label>
                </li>
                <li class="flex gap-2">
                    <input type="radio" id="posts-radio" name="search-type" value="posts" class="peer hidden">
                    <label for="posts-radio" class="peer-checked:text-dark-active">Posts</label>
                </li>
                <li class="flex gap-2">
                    <input type="radio" id="comments-radio" name="search-type" value="comments" class="peer hidden">
                    <label for="comments-radio" class="peer-checked:text-dark-active">Comments</label>
                </li>
            </ul>
        </section>
    </div>
</section>