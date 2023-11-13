// To delete a post or a comment

const deletePostButtons = document.querySelectorAll('.delete');
deletePostButtons.forEach(button => {
    button.addEventListener('click', deletePostOrComment);
})

async function deletePostOrComment(event) {
    if (event.target.classList.contains('delete')) {
        if (event.target.closest('article').classList.contains('post')) {
            deletePost(event);
        }
        else {
            deleteComment(event);
        }
    }
}

async function deletePost(event) {
    event.preventDefault();
    const article = event.target.closest('article');
    const id = article.dataset.id;
    const response = await fetch(`/posts/${id}`, {
        method: 'DELETE',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        }
    });
    console.log(response);
    if (response.ok) {
        article.remove();
    }
}

async function deleteComment(event) {
    event.preventDefault();
    const article = event.target.closest('article');
    const id = article.dataset.id;
    const response = await fetch(`/comments/${id}`, {
        method: 'DELETE',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        }
    })
    console.log(response);
    if (response.ok) {
        article.remove();
    }
}

