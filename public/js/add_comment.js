/*
<article class="post" data-id="{{ $post->id }}">
    <form class="new_comment">
        <input type="text" name="content" placeholder="Add a comment">
    </form>
</article>
*/
const commentForm = document.querySelector('form.add-comment');
if (commentForm != null) {
    commentForm.addEventListener('submit', submitAddComment);
}

async function submitAddComment(event) {
    event.preventDefault();
    const commentContent = commentForm.querySelector('input[type=text]').value;
    const post = event.currentTarget.closest('.post');
    const response = await submitAddPostOrComment(
        commentForm, 
        {content: commentContent, id_parent: post.dataset.id},
        'comment');
    // const response = await sendAjaxRequest('post', '/comment', {
    //     content: commentContent,
    //     id_parent: post.dataset.id,
    //     media: commentForm.querySelector('input[type=file]').files[0]
    // });
    // const response = await fetch('/comment', {
    //     headers: {
    //         'Content-Type': 'application/x-www-form-urlencoded',
    //         'X-CSRF-TOKEN': csrfToken
    //     },
    //     method: 'POST',
    //     body: encodeForAjax({
    //         'content': commentContent,
    //         'id_parent': post.dataset.id,
    //     })
    // });
    if (response.ok) {
        const data = await response.json();
        console.log(data);
        const commentsContainer = post.querySelector('.comments-container');
        // addCommentToDOM(commentsContainer, data);
        incrementCommentCount(post);
        commentForm.reset();
    }
    else {
        console.log('response not ok');
        // display error message to user
    }
}
function incrementCommentCount(post) {
    changeCommentCount(post, 1);
}
function decrementCommentCount(post) {
    changeCommentCount(post, -1);
}
function changeCommentCount(post, value) {
    const nrComments = post.querySelector('.nr-comments');
    nrComments.textContent = parseInt(nrComments.textContent) + value;
}
function addCommentToDOM(container, commentJson) {
    const comment = document.createElement('article');
    comment.classList.add('comment');
    comment.dataset.id = commentJson.id;
    const header = document.createElement('header');
    const h2 = document.createElement('h2');
    const a = document.createElement('a');
    a.href = `/users/${commentJson.id_created_by}`;
    a.textContent = commentJson.username;
    h2.appendChild(a);
    header.appendChild(h2);
    const h3 = document.createElement('h3');
    const like = document.createElement('a');
    like.href = '#';
    like.classList.add('like');
    like.textContent = '❤';
    h3.appendChild(like);
    const likes = document.createElement('span');
    likes.classList.add('likes');
    likes.textContent = commentJson.likes.length;
    h3.appendChild(likes);
    header.appendChild(h3);
    const h4 = document.createElement('h4');
    const nrComments = document.createElement('span');
    nrComments.classList.add('nr-comments');
    nrComments.textContent = commentJson.comments.length;
    h4.appendChild(nrComments);
    header.appendChild(h4);
    comment.appendChild(header);
    const p = document.createElement('p');
    p.textContent = commentJson.content;
    comment.appendChild(p);
    container.appendChild(comment);
}
