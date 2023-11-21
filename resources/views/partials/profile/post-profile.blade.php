<div class="post">
    <div class="post-header flex items-center space-x-4">
        <img src="{{ url('images/profile.png') }}" alt="Profile picture" class="profile-picture w-12 h-12 rounded-full">
        <div class="post-info">
            <span class="post-username font-bold">John Doe</span>
            <span class="post-timestamp text-gray-500">2 hours ago</span>
        </div>
    </div>
    <div class="post-content mt-4">
        <p>This is a social media post.</p>
        <img src="https://cdn.pixabay.com/photo/2015/04/23/22/00/tree-736885_1280.jpg" alt="Post image" class="post-image mt-4">
    </div>
    <div class="post-footer mt-4">
        <div class="post-actions">
            <button class="post-action"><i class="fa-solid fa-heart"></i></button>
            <button class="post-action"><i class="fa-solid fa-comment"></i></button>
        </div>
        <form class="write-comment mt-4">
            <label for="comment" class="block">Comment:</label>
            <textarea id="comment" name="comment" rows="5" cols="50" required class="border border-gray-300 p-2 rounded-md w-full mt-2"></textarea>
            <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded-md mt-2">Submit Comment</button>
        </form>
        <div class="post-comments mt-4">
            <div class="comment flex items-left flex-col">
                <!-- div for profile picture and username --> 
                <div class="comment-user flex items-center">
                    <img src="{{ url('images/profile.png') }}" alt="Profile picture" class="profile-picture w-6 h-6 rounded-full">
                    <span class="comment-username font-semibold ml-5">Jane Smith</span>
                </div>
                <div class="comment-content">
                    <p>This is a comment on the post.</p>
                </div>
            </div>
        </div>
    </div>
</div>
