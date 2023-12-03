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
function showAddPostForm() {
    show(addPostForm);
    hide(addPostOn);
    show(addPostOff);
    show(darkOverlay); // Show dark overlay
}
function hideAddPostForm() {
    hide(addPostForm);
    show(addPostOn);
    hide(addPostOff);
    addPostForm.reset();
    clearFileInputWrapper(getFileInputWrapper(addPostForm));
    hide(darkOverlay); // Hide dark overlay
}

async function submitAddPost(event) {
    event.preventDefault();
    const content = getTextField(addPostForm).value;

    const data = await submitAddPostOrComment(addPostForm, {'content': content}, 'post');
    if (data != null) {
        prependPostsToTimeline([data.postHTML]);
        
        addPostForm.reset();
        clearFileInputWrapper(getFileInputWrapper(addPostForm));
        if (addPostOff) {
            hideAddPostForm();
        }
    }
}
