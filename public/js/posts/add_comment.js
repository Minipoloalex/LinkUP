import { submitAddPostOrComment, getTextField } from "./post_helpers.js";
import { clearFileInputWrapper, getFileInputWrapper } from "../file_input.js";
import { incrementCommentCount } from "./post_helpers.js";
import { parseHTML } from "../general_helpers.js";
import { addEventListenersToComment } from "./post_event_listeners.js";

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
        commentsContainer.prepend(commentHTML);
        incrementCommentCount(post);
    }
}