import { submitAddPostOrComment } from './post.js';

const commentForm = document.querySelector('form.add-comment');
if (commentForm != null) {
    commentForm.addEventListener('submit', submitAddComment);
}

async function submitAddComment(event) {
    event.preventDefault();
    const commentContent = getTextField(commentForm).value;

    const post = event.currentTarget.closest('.post');
    const data = await submitAddPostOrComment(commentForm, {
        content: commentContent,
        id_parent: post.dataset.id
    }, 'comment');

    if (data != null) {
        const commentsContainer = post.querySelector('.comments-container');
        const commentHTML = parseHTML(data.commentHTML);

        addEventListenersToComment(commentHTML);
        commentsContainer.appendChild(commentHTML);
        incrementCommentCount(post);

        commentForm.reset();
        clearFileInputWrapper(getFileInputWrapper(commentForm));
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
