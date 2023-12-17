import { decrementCommentCount } from "./post_helpers.js";
import { sendAjaxRequest } from "../ajax.js";
import { swalConfirmDelete } from "../general_helpers.js";


const isAdmin = document.querySelector('meta[name="is-admin"]') != null;

const deletePostButtons = document.querySelectorAll('.delete-post');
export function addEventListenerToDeletePostButton(button) {
    const listener = (url, redirectTo) => {
        button.addEventListener('click', (event) => deletePostOrComment(event, url, redirectTo));
    }
    if (isAdmin) {
        listener((id) => `/admin/post/${id}`, '/admin/dashboard');
    }
    else {
        listener((id) => `/post/${id}`, '/home');
    }
}

export async function deletePostOrComment(event, deleteURL, redirectTo) {
    event.preventDefault();
    const post = event.currentTarget.closest('article');

    const isComment = post.classList.contains('comment');
    const titleText = isComment ? 'Delete Comment?' : 'Delete Post?';
    const descriptionText = 'Are you sure you want to delete this ' + (isComment ? 'comment?' : 'post?');
    const isDeletedText = isComment ? 'Your comment has been deleted.' : 'Your post has been deleted.';

    const confirmAction = async () => {
        const postId = post.dataset.id;
        const isDeleted = deletePost(post, postId, isComment, deleteURL);
        if (isDeleted) {
            await Swal.fire('Deleted!', isDeletedText, 'success');
        }

        if (isDeleted && window.location.href.includes(`/post/${postId}`)) {    // post page must redirect
            window.location.href = redirectTo;
        }
    };
    await swalConfirmDelete(titleText, descriptionText, confirmAction, null, 'Yes, delete.');
}
/**
 * Deletes a post or comment.
 * Returns true if deleted it, false otherwise.
 */
async function deletePost(post, postId, isComment, deleteURL) {
    const data = await sendAjaxRequest('DELETE', deleteURL(postId));
    if (data != null) {
        if (isComment) {   // if it's a comment, decrement comment count
            decrementCommentCount(post.parentElement.closest('article'));
        }
        post.remove();
        return true;
    }
    return false;
}

deletePostButtons.forEach(addEventListenerToDeletePostButton);
