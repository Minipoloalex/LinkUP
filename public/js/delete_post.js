// To delete a post or a comment
const deletePostButtons = document.querySelectorAll('.delete-post');
deletePostButtons.forEach(button => {
    button.addEventListener('click', deletePostOrComment);
})

async function deletePostOrComment(event) {
    if (confirm('Are you sure you want to delete this post?')) {
        console.log('deleting post')
        const post = event.currentTarget.closest('article');
        const postId = post.dataset.id;
        deletePost(post, postId);
        if (!window.location.href.includes(`/post/${postId}`)) {    // post page must redirect
            event.preventDefault();
        }
    }
    else {
        event.preventDefault();
    }
}

async function deletePost(post, postId) {
    const response = await sendAjaxRequest('DELETE', `/post/${postId}`);
    console.log(response);
    if (response.ok) {
        post.remove();
    }
}
