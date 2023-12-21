import { parseHTML } from "../general_helpers.js";
import { submitDataPostOrComment, removeImageContainer } from "./post_helpers.js";
import { getTextField, deleteImage } from "./post_helpers.js";
import { clearFileInputWrapper, getFileInputWrapper } from "../file_input.js";
import { sendAjaxRequest } from "../ajax.js";


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
    editForm.addEventListener('submit', submitEditPost);
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

async function togglePostPrivacy(privacyIcon, postId) {
    const data = await sendAjaxRequest('PATCH', `/post/${postId}/privacy`)
    if (data != null) {
        const isPrivate = data.is_private;
        if (isPrivate) {
            privacyIcon.classList.remove('fa-unlock');
            privacyIcon.classList.add('fa-lock');
        } else {
            privacyIcon.classList.remove('fa-lock');
            privacyIcon.classList.add('fa-unlock');
        }
        const description = isPrivate ? 'Post set to private' : 'Post set to public';
        await Swal.fire({
            title: '<h1 class="text-dark-active">Privacy updated</h1>',
            html: `<p class="text-white">${description}</p>`,
            background: '#333333',
            showConfirmButton: true,
            confirmButtonText: 'Ok',
            confirmButtonColor: '#A58AD6',
            icon: 'success',
            iconColor: '#A58AD6',
        });
    }
}

// Event listener for clicking on the privacy icon
document.querySelectorAll('.privacy-post-button').forEach(icon => {
    icon.addEventListener('click', togglePrivacyEventListener);
});
export async function togglePrivacyEventListener(event) {
    event.preventDefault();
    const button = event.currentTarget;
    const postId = button.dataset.postId;
    const privacyIcon = button.querySelector('i');
    await togglePostPrivacy(privacyIcon, postId);
}
