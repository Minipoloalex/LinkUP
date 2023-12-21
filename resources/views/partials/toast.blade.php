<a id="toast" href="/home" class="fixed -top-12 left-[20vw] w-[60vw] lg:left-[35vw] z-50 lg:w-[30vw] min-h-[3rem] rounded-md px-2 flex items-center
                    dark:bg-dark-active dark:text-dark-secondary translate-y-16 invisible
                    transition-all duration-300 ease-linear">
    <div class="min-h-[3rem] min-w-[2rem] flex items-center justify-center ml-2">
        <div>
            <img id="toast-image" src="{{ asset('images/users/default.png') }}" alt="avatar"
                class="w-8 h-8 rounded-full">
        </div>
    </div>
    <div class="flex flex-col items-start justify-center min-h-[3rem] ml-2 text-xs">
        <div class="font-bold flex items-center">
            <h2 id="toast-username">username</h2>
        </div>
        <div class="font-bold">
            <h2 id="toast-message">liked your post.</h2>
        </div>
    </div>
</a>