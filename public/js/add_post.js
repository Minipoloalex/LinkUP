const addPostOn = document.querySelector('.add-post-on');
const addPostOff = document.querySelector('.add-post-off');
const addPostForm = document.querySelector('form.add-post');
const darkOverlay = document.getElementById('dark-overlay');

if (addPostOn) {
    addPostOn.addEventListener('click', showAddPostForm);
    addPostOff.addEventListener('click', hideAddPostForm);
}
if (addPostForm) {
    addPostForm.addEventListener('submit', submitAddPost);
}
function getFileInputWrapper(form) {
    return form.querySelector('.file-input-wrapper');
}
function showAddPostForm() {
    addPostForm.classList.remove('hidden');
    addPostOn.classList.add('hidden');
    addPostOff.classList.remove('hidden');
    darkOverlay.classList.remove('hidden'); // Show dark overlay
}
function hideAddPostForm() {
    addPostForm.classList.add('hidden');
    addPostOn.classList.remove('hidden');
    addPostOff.classList.add('hidden');
    addPostForm.reset();
    clearFileInputWrapper(getFileInputWrapper(addPostForm));
    darkOverlay.classList.add('hidden'); // Hide dark overlay
}

async function submitAddPost(event) {
    event.preventDefault();
    const content = getTextField(addPostForm).value;

    const response = await submitAddPostOrComment(addPostForm, {'content': content}, 'post');
    if (response.ok) {
        const data = await response.json();
        prependPostsToTimeline([data]);
        
        addPostForm.reset();
        clearFileInputWrapper(getFileInputWrapper(addPostForm));
        if (addPostOff) {
            hideAddPostForm();
        }
        
        // addPost(<container>, <post_info>)
    }
    else {
        console.log('Error: ' + response.status);
    }
}
