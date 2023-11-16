const editPostButtons = document.querySelectorAll('.edit-post');
editPostButtons.forEach(button => {
    button.addEventListener('click', toggleEditEvent);
});
const editPostFields = document.querySelectorAll('edit-content');
editPostFields.forEach(field => {
    field.addEventListener('submit', submitEditPost);
});

function toggleEditEvent(event) {
    event.preventDefault();
    const post = event.currentTarget.closest('article');

    const content = post.querySelector('.post-content');
    const editForm = post.querySelector('form.edit-content');
    const textField = editForm.querySelector('.textfield');
    
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

    const textField = form.querySelector('input.textfield');
    const newContent = textField.value;

    const response = await sendAjaxRequest('put', `/post/edit/${postId}`, {content: newContent});
    if (response.ok) {
        // const data = response.json();    // don't need the data
        const postContentElement = post.querySelector('.post-content');

        postContentElement.textContent = newContent;
        toggleEdit(postContentElement, form, textField);
    }
    else {
        console.log('Error: ', response.status);
        // show error message to user
    }
}
