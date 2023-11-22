function getTextField(form) {
    return form.querySelector('textarea');
}
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
    img.src = `/post/${postId}/image?_=${Date.now()}`; // Add timestamp to prevent caching (new image)
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
async function deleteImage(event) {
    event.preventDefault();
    if (confirm('Are you sure you want to delete this image?')) {
        const button = event.currentTarget;
        const postId = button.dataset.id;
        
        const imageContainer = button.closest('.image-container');
        const response = await sendAjaxRequest('delete', `/post/${postId}/image`);
        if (response.ok) {
            imageContainer.remove();
        }
        else {
            console.log('Error: ', response.status);
        }
    }
}
function buildPostForm(formClass, textPlaceholder, buttonText, contentValue) {
    const form = document.createElement('form');
    const formClasses = formClass.split(' '); // Split formClass into an array of classes
    
    formClasses.forEach(className => {
        form.classList.add(className);
    });
    form.classList.add('flex', 'flex-col');
    
    form.innerHTML = `
        <textarea name="content" required placeholder="${textPlaceholder}" class="p-2 bg-gray-600 rounded text-white focus:outline-none focus:bg-gray-700 w-full">${contentValue}</textarea>
        <button type="submit" class="order-last bg-gray-500 rounded px-4 py-2 mx-5 text-white">${buttonText}</button>
        <div class="file-input-wrapper">
            <button class="upload-file bg-gray-500 rounded px-4 py-2 m-6 text-white">Upload image</button>
            <input type="file" accept=".jpg, .jpeg, .png, .gif, .mp4" name="media" class="hidden">
            <button class="remove-file hidden bg-gray-500 rounded px-4 py-2 m-6 text-white">Clear image</button>
            <span class="file-name">No file selected</span>
        </div>
    `;
    return form;
}
function buildPostInfo(postJson, editable) {
    const postInfo = document.createElement('div');
    postInfo.classList.add('post-info');

    postInfo.innerHTML = `
        <header>
            <div class="user-date">
                <img class="user-image" src="/images/profile.png" alt="User photo">
                <a href="/profile/${postJson.created_by.username}">${postJson.created_by.username}</a>
                <span class="date">${postJson.created_at}</span>
            </div>
            ${editable ? `
                <div class="edit-delete-post">
                    <a href="#" class="edit edit-post">&#9998;</a>
                    <a href="home" class="delete delete-post">&#10761;</a>
                </div>
            ` : ''}
        </header>
        <div class="post-body">
            <a class="post-link" href="/post/${postJson.id}">
                <p class="post-content">${postJson.content}</p>
                ${postJson.media != null ? `
                    <div class="image-container">
                        <img src="/post/${postJson.id}/image" alt="A post image">
                        ${editable ? `
                            <a href="#" class="delete delete-image" data-id="${postJson.id}">&#10761;</a>
                        ` : ''}
                    </div>
                ` : ''}
            </a>
        </div>
        <div class="post-footer">
            <h3 class="post-likes">
                <a href="#" class="like">&#10084;</a>
                <span class="likes">${postJson.likes.length}</span>
            </h3>
            <span class="nr-comments">${postJson.comments.length}</span>
        </div>
    `;

    if (editable) {
        const editPostForm = buildPostForm('edit-post-info hidden', 'Edit post', 'Update Post', postJson.content);
        postInfo.querySelector('.post-body').appendChild(editPostForm);

        const deletePostButton = postInfo.querySelector('.delete-post');
        deletePostButton.addEventListener('click', deletePostOrComment);

        const editPostButton = postInfo.querySelector('.edit-post');
        editPostButton.addEventListener('click', toggleEditEvent);
        const editPostField = postInfo.querySelector('.edit-post-info');
        editPostField.addEventListener('submit', submitEditPost);
        if (postJson.media != null) {
            const deleteImageButton = postInfo.querySelector('.delete-image');
            deleteImageButton.addEventListener('click', deleteImage);
        }

        handlerFileInput(postInfo.querySelector('.file-input-wrapper'));
    }
    return postInfo;
}


function buildComment(commentJson) {
    const comment = document.createElement('article');
    comment.classList.add('comment');
    comment.dataset.id = commentJson.id;
    
    comment.appendChild(buildPostInfo(commentJson, true));
    return comment;
}
function buildPost(postJson, displayComments, editable) {
    const post = document.createElement('article');
    post.classList.add('post', 'w-full');
    post.dataset.id = postJson.id;
    post.dataset.date = postJson.created_at;
    
    const postInfo = buildPostInfo(postJson, editable);
    post.appendChild(postInfo);
    
    if (displayComments && postJson.comments.length > 0) {
        const commentsContainer = document.createElement('div');
        commentsContainer.classList.add('comments-container');
        postJson.comments.forEach(commentJson => {
            const comment = buildComment(commentJson);
            commentsContainer.appendChild(comment);
        });
        post.appendChild(commentsContainer);
    }

    return post;
}
function addPostToDom(container, postJson, displayComments) {
    const post = buildPost(postJson, displayComments, false);
    container.appendChild(post);
}
function addCommentToDOM(container, commentJson) {
    const comment = buildComment(commentJson);
    container.appendChild(comment);
}

