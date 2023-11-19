async function submitAddPostOrComment(form, data, type) {  // type = 'post' or 'comment'
    return await submitDataPostOrComment(form, data, `/${type}`, 'post');
}
async function submitDataPostOrComment(form, data, url, method) {
    // includes the file
    const file = form.querySelector('input[type=file]').files;
    if (file.length > 0) {
        const formData = new FormData();
        for (const key in data) {
            formData.append(key, data[key]);
        }
        formData.append('media', file[0]);
        return await fetch(url, {
            method: method,
            headers: {
                'X-CSRF-TOKEN': getCsrfToken(),
            },
            body: formData
        });
    }
    return await sendAjaxRequest(method, url, data);
}
function removeImageContainer(post) {
    const imageContainer = post.querySelector('.image-container');
    if (imageContainer) {
        imageContainer.remove();
    }
}
function addImageContainer(postContentElement, postId) {
    // check partials.post_info
    const imageContainer = document.createElement('div');
    imageContainer.classList.add('image-container');

    const img = document.createElement('img');
    img.src = `/post/${postId}/image`;      // THIS IS BEING CACHED AND WE DO NOT WANT THAT
    img.alt = 'A post image';
    imageContainer.appendChild(img);

    const deleteButton = document.createElement('a');
    deleteButton.href = '#';
    deleteButton.classList.add('delete', 'delete-image');
    deleteButton.dataset.id = postId;
    deleteButton.innerHTML = '&#10761;';
    deleteButton.addEventListener('click', deleteImage);
    imageContainer.appendChild(deleteButton);

    postContentElement.after(imageContainer);
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
// function addCommentToDOM(post/container, commentJson) {
//     const comment = document.createElement('article');
//     comment.classList.add('comment');
//     comment.dataset.id = commentJson.id;
//     const header = document.createElement('header');
//     const h2 = document.createElement('h2');
//     const a = document.createElement('a');
//     a.href = `/users/${commentJson.id_created_by}`;
//     a.textContent = commentJson.username;
//     h2.appendChild(a);
//     header.appendChild(h2);
//     const h3 = document.createElement('h3');
//     const like = document.createElement('a');
//     like.href = '#';
//     like.classList.add('like');
//     like.textContent = '❤';
//     h3.appendChild(like);
//     const likes = document.createElement('span');
//     likes.classList.add('likes');
//     likes.textContent = commentJson.likes.length;
//     h3.appendChild(likes);
//     header.appendChild(h3);
//     const h4 = document.createElement('h4');
//     const nrComments = document.createElement('span');
//     nrComments.classList.add('nr-comments');
//     nrComments.textContent = commentJson.comments.length;
//     h4.appendChild(nrComments);
//     header.appendChild(h4);
//     comment.appendChild(header);
//     const p = document.createElement('p');
//     p.textContent = commentJson.content;
//     comment.appendChild(p);
//     container.appendChild(comment);
// }
