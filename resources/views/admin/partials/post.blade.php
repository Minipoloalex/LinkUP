<div class="flex mt-4 content-center justify-center items-center w-full mx-auto">
    @include('partials.post', ['post' => $post, 'displayComments' => false, 'showAddComment' => false, 'showEdit' => false, 'hasAdminLink' => true])

    <div class="flex flex-col justify-center items-center w-1/3">
        <form action="{{ route('admin.posts.delete', ['id' => $post->id]) }}" method="POST">
            @csrf
            @method('DELETE')
            <button type="submit" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">
                Delete
            </button>
        </form>
    </div>
</div>