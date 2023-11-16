/*
<button class="toggle-add-post">Add Post</button>
<form class="add-post">
    <input type="text" name="content" placeholder="Add a post" value="">
</form>
*/
const toggleAddPost = document.querySelector('.toggle-add-post');
const addPostForm = document.querySelector('form.add-post');
if (addPostForm) {
    addPostForm.addEventListener('submit', submitAddPost);
}
async function submitAddPost(event) {
    event.preventDefault();
    const content = document.querySelector('.add-post input[name="content"]').value;
    const response = await sendAjaxRequest('post', '/post', {content: content});
    if (response.ok) {
        const data = await response.json();
        console.log(data);
        const addPostTextField = addPostForm.querySelector('input[name="content"]');
        addPostTextField.value = '';
        // addPost(<container>, <post_info>)
    }
    else {
        console.log('Error: ' + response.status);
    }
}
