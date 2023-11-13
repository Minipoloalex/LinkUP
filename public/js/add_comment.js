/*
<article class="post" data-id="{{ $post->id }}">
    <form class="new_comment">
        <input type="text" name="content" placeholder="Add a comment">
    </form>
</article>
*/
const commentForm = document.querySelector('.new_comment');
if (commentForm != null) {
    commentForm.addEventListener('submit', async (event) => {
        event.preventDefault();
        const commentContent = commentForm.querySelector('input[type=text]').value;
        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        const post = event.currentTarget.closest('.post');

        const response = await fetch('/comments', {
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
                'X-CSRF-TOKEN': csrfToken
            },
            method: 'POST',
            body: encodeForAjax({
                'content': commentContent,
                'id_parent': post.dataset.id,
            })
        });
        if (response.ok) {
            const data = await response.json();
            console.log(data);
            const commentsContainer = post.querySelector('.comments-container');
            // addCommentToDOM(commentsContainer, data);
            commentForm.reset();
        }
        else {
            console.log('response not ok');
            // display error message to user
        }
    });
}

function addCommentToDOM(container, commentJson) {
    /*
    <article class="comment" data-id="{{ $comment->id }}">
        <header>
    <h2><a href="/users/{{ $post->id_created_by }}">{{ $post->createdBy->username }}</a></h2>
    <h3>
        <a href="#" class="like">&#10084;</a>
            <span class="likes">{{ $post->likes->count() }}</span>
    </h3>
    <h3>
        <span class="date">{{ $post->created_at }}</span>
    </h3>
    <a href="#" class="delete">&#10761;</a>
</header>
<p>{{ $post->content }}</p>
<h4>
    <span class="nr-comments">{{ $post->comments->count() }}</span>
</h4>

    </article>
    */
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
