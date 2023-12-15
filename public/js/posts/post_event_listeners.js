import { addEventListenerToDeletePostButton } from "./delete_post.js";
import { toggleEditEvent, submitEditPost } from "./edit_post.js";
import { deleteImage } from "./post_helpers.js";
import { handlerFileInput } from "../file_input.js";
import { addToggleLikeEventListener } from "./like.js";

export function addEventListenersToComment(comment) {
    const deleteCommentButton = comment.querySelector('.delete-post');
    if (deleteCommentButton) {
        addEventListenerToDeletePostButton(comment.querySelector('.delete-post'));
    }
    
    const editCommentButton = comment.querySelector('.edit-post');
    if (editCommentButton) {
        editCommentButton.addEventListener('click', toggleEditEvent);
    }

    const editCommentField = comment.querySelector('.edit-post-info');
    if (editCommentField) {
        editCommentField.addEventListener('submit', submitEditPost);
    }
    const deleteImageButton = comment.querySelector('.delete-image');
    if (deleteImageButton) {
        deleteImageButton.addEventListener('click', deleteImage);
    }
    const fileInputWrapper = comment.querySelector('.file-input-wrapper');
    if (fileInputWrapper) {
        handlerFileInput(fileInputWrapper);
    }
}

export async function addEventListenersToPost(postElement) {
    const deletePostButton = postElement.querySelector('.delete-post');
    addEventListenerToDeletePostButton(deletePostButton);

    const comments = postElement.querySelectorAll('.comment');
    comments.forEach(addEventListenersToComment);

    const likes = postElement.querySelectorAll('.like-button');
    likes.forEach(addToggleLikeEventListener);
}
