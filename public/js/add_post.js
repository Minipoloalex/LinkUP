// const toggleAddPost = document.querySelector('.toggle-add-post');
const addPostForm = document.querySelector('form.add-post');    
if (addPostForm) {
    addPostForm.addEventListener('submit', submitAddPost);
}
async function submitAddPost(event) {
    event.preventDefault();
    const content = document.querySelector('.add-post input[name="content"]').value;
    const files = addPostForm.querySelector('input[type=file]').files;
    let response;
    if (files.length > 0) {
        const formData = new FormData();
        formData.append('content', content);
        formData.append('media', files[0]);
        response = await fetch('/post', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': getCsrfToken()
            },
            body: formData
        });
    }
    else response = await sendAjaxRequest('post', '/post', {content: content});

    console.log(response)
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
