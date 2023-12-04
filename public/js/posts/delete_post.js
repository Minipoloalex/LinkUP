import { decrementCommentCount } from "./post_helpers.js";
import { sendAjaxRequest } from "../ajax.js";

const deletePostButtons = document.querySelectorAll('.delete-post');
deletePostButtons.forEach(button => {
    button.addEventListener('click', deletePostOrComment);
})

export async function deletePostOrComment(event) {
    if (confirm('Are you sure you want to delete this post?')) {
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
    const data = await sendAjaxRequest('DELETE', `/post/${postId}`);
    if (data != null) {
        if (post.classList.contains('comment')) {   // if it's a comment, decrement comment count
            decrementCommentCount(post.parentElement.closest('article'));
        }
        post.remove();
    }
}
