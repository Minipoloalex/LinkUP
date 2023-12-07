import { submitAddPostOrComment, getTextField } from "./post_helpers.js";
import { clearFileInputWrapper, getFileInputWrapper } from "../file_input.js";
import { hide, show } from '../general_helpers.js';
import { prependPostsToTimeline } from "./post_render.js";

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

async function showAddPostForm(event) {
    event.preventDefault();
    show(addPostForm);
    hide(addPostOn);
    show(addPostOff);
    show(darkOverlay);
    getTextField(addPostForm).focus();
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
