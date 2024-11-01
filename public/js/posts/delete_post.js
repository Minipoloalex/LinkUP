import { decrementCommentCount } from "./post_helpers.js";
import { sendAjaxRequest } from "../ajax.js";
import { swalConfirmDelete } from "../general_helpers.js";
import { show } from "../general_helpers.js";
import { getNoneElement } from "../group/group.js";

const isAdmin = document.querySelector('meta[name="is-admin"]') != null;

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
    const isDeletedText = isComment ? 'This comment has been deleted.' : 'This post has been deleted.';

    const confirmAction = async () => {
        const postId = post.dataset.id;
        const postsContainer = post.parentElement;
        const isDeleted = await deletePost(post, postId, isComment, deleteURL);
        if (isDeleted) {
            if (postsContainer.querySelector('.post') == null) {
                show(getNoneElement(postsContainer));
            }
            await Swal.fire({
                html: '<p class="text-dark-active">' + isDeletedText + '</p>',
                icon: 'success',
                iconColor: '#A58AD6',
                confirmButtonText: 'Ok',
                confirmButtonColor: '#A58AD6',
                background: '#333333',
            });
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

const deletePostButtons = document.querySelectorAll('.delete-post');
deletePostButtons.forEach(addEventListenerToDeletePostButton);
