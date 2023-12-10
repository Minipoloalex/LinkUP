import { submitAddPostOrComment, getTextField } from "./post_helpers.js";
import { clearFileInputWrapper, getFileInputWrapper } from "../file_input.js";
import { hide, show, parseHTML } from '../general_helpers.js';
import { prependPostsToTimeline } from "./post_render.js";
import { prependInPostSection } from "../group/group.js";

const addPostOn = document.querySelector('.add-post-on');
const addPostOff = document.querySelector('.add-post-off');
const addPostForm = document.querySelector('form.add-post');
const darkOverlay = document.getElementById('dark-overlay');

const groupIdElement = document.getElementById('group-id');

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
    const groupId = groupIdElement != null ? groupIdElement.getAttribute('value') : null;

    const data = await submitAddPostOrComment(addPostForm, {'content': content, id_group: groupId}, 'post');

    if (data != null) {
        if (groupId != null) {
            const postElement = parseHTML(data.postHTML);
            prependInPostSection(postElement);
        }
        else {
            prependPostsToTimeline([data.postHTML]);
        }

        addPostForm.reset();
        clearFileInputWrapper(getFileInputWrapper(addPostForm));
        if (addPostOff) {
            hideAddPostForm();
        }
    }
}
