// To delete a post or a comment
console.log(window.location.href);
const deletePostButtons = document.querySelectorAll('.delete');
deletePostButtons.forEach(button => {
    button.addEventListener('click', deletePostOrComment);
})

async function deletePostOrComment(event) {
    if (confirm('Are you sure you want to delete this post?')) {
        const post = event.target.closest('article');
        const postId = post.dataset.id;
        deletePost(postId);
        if (!window.location.href.includes(`/post/${postId}`)) {    // post page must redirect
            event.preventDefault();
        }
    }
    else {
        event.preventDefault();
    }   
}

async function deletePost(postId) {
    const response = await sendAjaxRequest('DELETE', `/post/${postId}`);
    console.log(response);
    if (response.ok) {
        article.remove();
    }
}
