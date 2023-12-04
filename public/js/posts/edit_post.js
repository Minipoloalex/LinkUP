import { parseHTML } from "../general_helpers.js";
import { submitDataPostOrComment, removeImageContainer } from "./post_helpers.js";
import { getTextField, deleteImage } from "./post_helpers.js";
import { clearFileInputWrapper, getFileInputWrapper } from "../file_input.js";


const editPostButtons = document.querySelectorAll('.edit-post');
editPostButtons.forEach(button => {
    button.addEventListener('click', toggleEditEvent);
});
const editPostFields = document.querySelectorAll('edit-post-info');
editPostFields.forEach(field => {
    field.addEventListener('submit', submitEditPost);
});
const deleteImageButtons = document.querySelectorAll('.delete-image');
deleteImageButtons.forEach(button => {
    button.addEventListener('click', deleteImage);
});


export function toggleEditEvent(event) {
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
    editForm.addEventListener('submit', submitEditPost);    // TODO: fix this
}
export async function submitEditPost(event) {  // submitted the form
    event.preventDefault();
    const form = event.currentTarget;

    const post = form.closest('article');
    const postId = post.dataset.id;

    const textField = getTextField(form);
    const newContent = textField.value;

    const data = await submitEditPostOrComment(form, {'content': newContent}, postId);
    if (data != null) {
        const postBody = post.querySelector('.post-body');
        const postContentElement = postBody.querySelector('.post-content');
        postContentElement.textContent = newContent;
        toggleEdit(postContentElement, form, textField);

        clearFileInputWrapper(getFileInputWrapper(form));

        if (data.hasNewMedia) {
            removeImageContainer(post);
            const imageContainer = parseHTML(data.postImageHTML);
            
            const deleteButton = imageContainer.querySelector('.delete-image');
            deleteButton.addEventListener('click', deleteImage);

            postBody.appendChild(imageContainer);
        }
    }
}

async function submitEditPostOrComment(form, data, postId) {
    // Explains the use of _method https://laravel.com/docs/10.x/routing#form-method-spoofing
    data._method = 'put';
    return await submitDataPostOrComment(form, data, `/post/${postId}`, 'post');
}
