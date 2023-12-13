import { submitAddPostOrComment, getTextField } from "./post_helpers.js";
import { clearFileInputWrapper, handlerFileInput, getFileInputWrapper } from "../file_input.js";
import { incrementCommentCount } from "./post_helpers.js";
import { parseHTML } from "../general_helpers.js";
import { deletePostOrComment } from "./delete_post.js";
import { toggleEditEvent, submitEditPost } from "./edit_post.js";
import { deleteImage } from "./post_helpers.js";

const commentForm = document.querySelector('form.add-comment');
if (commentForm != null) {
    commentForm.addEventListener('submit', submitAddComment);
}

async function submitAddComment(event) {
    event.preventDefault();
    const commentContent = getTextField(commentForm).value;

    const post = event.currentTarget.closest('.post');
    const promise = submitAddPostOrComment(commentForm, {
        content: commentContent,
        id_parent: post.dataset.id
    }, 'comment');
    
    commentForm.reset();    // already sent data, avoid user sending same comment twice
    clearFileInputWrapper(getFileInputWrapper(commentForm));
    
    const data = await promise;
    if (data != null) {
        const commentsContainer = post.querySelector('.comments-container');
        const commentHTML = parseHTML(data.commentHTML);

        addEventListenersToComment(commentHTML);
        commentsContainer.appendChild(commentHTML);
        incrementCommentCount(post);
    }
}
function addEventListenersToComment(comment) {
    const deleteCommentButton = comment.querySelector('.delete-post');
    deleteCommentButton.addEventListener('click', deletePostOrComment);

    const editCommentButton = comment.querySelector('.edit-post');
    editCommentButton.addEventListener('click', toggleEditEvent);

    const editCommentField = comment.querySelector('.edit-post-info');
    editCommentField.addEventListener('submit', submitEditPost);

    const deleteImageButton = comment.querySelector('.delete-image');
    if (deleteImageButton) {
        deleteImageButton.addEventListener('click', deleteImage);
    }

    handlerFileInput(comment.querySelector('.file-input-wrapper'));
}
