/*const unlikeButton = document.querySelectorAll('.like-button');
unlikeButton.forEach(button => {
    button.addEventListener('click', removeLikeFromPost);
})

async function removeLikeFromPost(event) {
    const post = event.currentTarget.closest('article');
    const postId = post.dataset.id;
    deleteLike(post, postId);
}

async function deleteLike(post, postId) {
    const data = await sendAjaxRequest('deleteLike', `/post/${postId}`);
    if (data != null) {
        const likeButton = post.querySelector('.like-button');
        const likeCount = post.querySelector('.like-count');
        likeButton.classList.remove('liked');
        likeCount.textContent = data.likeCount;
    }
}

*/