const commentForm = document.querySelector('form.add-comment');
if (commentForm != null) {
    commentForm.addEventListener('submit', submitAddComment);
}

async function submitAddComment(event) {
    event.preventDefault();
    const commentContent = commentForm.querySelector('input[type=text]').value;
    const post = event.currentTarget.closest('.post');
    const response = await submitAddPostOrComment(commentForm, {
        content: commentContent,
        id_parent: post.dataset.id
    }, 'comment');

    if (response.ok) {
        const data = await response.json();
        console.log(data);
        // const commentsContainer = post.querySelector('.comments-container');
        // addCommentToDOM(commentsContainer, data);
        incrementCommentCount(post);
        commentForm.reset();
    }
    else {
        console.log('response not ok');
        // display error message to user
    }
}
