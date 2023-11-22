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
        
        addCommentToDOM(commentsContainer, data);
        incrementCommentCount(post);

        commentForm.reset();
        clearFileInputWrapper(getFileInputWrapper(commentForm));
    }
}
