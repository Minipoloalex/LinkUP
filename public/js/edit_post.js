const editPostButtons = document.querySelectorAll('.edit-post');
editPostButtons.forEach(button => {
    button.addEventListener('click', toggleEditEvent);
});
const editPostFields = document.querySelectorAll('edit-post-info');
editPostFields.forEach(field => {
    field.addEventListener('submit', submitEditPost);
});

function getTextField(form) {
    return form.querySelector('input[type="text"]');
}

function toggleEditEvent(event) {
    event.preventDefault();
    const post = event.currentTarget.closest('article');

    const content = post.querySelector('.post-content');
    const editForm = post.querySelector('form.edit-post-info');
    const textField = getTextField(editForm);
    
    toggleEdit(content, editForm, textField);
}
function toggleEdit(content, editForm, textField) {
    content.classList.toggle('hidden');
    editForm.classList.toggle('hidden');

    if (!editForm.classList.contains('hidden')) {
        textField.focus();
    }
    editForm.addEventListener('submit', submitEditPost);
}
async function submitEditPost(event) {  // submitted the form
    event.preventDefault();
    const form = event.currentTarget;

    const post = form.closest('article');
    const postId = post.dataset.id;

    const textField = getTextField(form);
    const newContent = textField.value;

    const response = await submitEditPostOrComment(form, {'content': newContent}, postId);
    if (response.ok) {
        const data = await response.json();
        console.log(data);
    
        const postContentElement = post.querySelector('.post-content');
        postContentElement.textContent = newContent;
        toggleEdit(postContentElement, form, textField);
        
        if (data['hasNewMedia']) {

            removeImageContainer(post);
            addImageContainer(postContentElement, postId);
        }
        
    }
    else {
        console.log('Error: ', response.status);
        // show error message to user
    }
}

const deleteImageButtons = document.querySelectorAll('.delete-image');
deleteImageButtons.forEach(button => {
    button.addEventListener('click', deleteImage);
});
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
