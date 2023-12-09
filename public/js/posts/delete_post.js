import { decrementCommentCount } from "./post_helpers.js";
import { sendAjaxRequest } from "../ajax.js";
import { swalConfirmDelete } from "../general_helpers.js";

const deletePostButtons = document.querySelectorAll('.delete-post');
deletePostButtons.forEach(button => {
    button.addEventListener('click', deletePostOrComment);
})

export async function deletePostOrComment(event) {
    event.preventDefault();
    const post = event.currentTarget.closest('article');

    const isComment = post.classList.contains('comment');
    const titleText = isComment ? 'Delete Comment?' : 'Delete Post?';
    const descriptionText = 'Are you sure you want to delete this ' + (isComment ? 'comment?' : 'post?');
    
    const confirmAction = async () => {
        const postId = post.dataset.id;
        const isDeleted = deletePost(post, postId, isComment);
        if (isDeleted && window.location.href.includes(`/post/${postId}`)) {    // post page must redirect
            window.location.href = '/home';
        }
    };
    await swalConfirmDelete(titleText, descriptionText, confirmAction, null, 'Yes, delete.');
}
/**
 * Deletes a post or comment.
 * Returns true if deleted it, false otherwise.
 */
async function deletePost(post, postId, isComment) {
    const data = await sendAjaxRequest('DELETE', `/post/${postId}`);
    if (data != null) {
        if (isComment) {   // if it's a comment, decrement comment count
            decrementCommentCount(post.parentElement.closest('article'));
        }
        post.remove();
        return true;
    }
    return false;
}
