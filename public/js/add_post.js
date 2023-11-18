// const toggleAddPost = document.querySelector('.toggle-add-post');
const addPostForm = document.querySelector('form.add-post');    
if (addPostForm) {
    addPostForm.addEventListener('submit', submitAddPost);
}
async function submitAddPostOrComment(form, data, type) {  // type = 'post' or 'comment'
    const file = form.querySelector('input[type=file]').files;
    if (file.length > 0) {
        const formData = new FormData();
        for (const key in data) {
            formData.append(key, data[key]);    // e.g. formData.append('content', content);
        }
        formData.append('media', file[0]);
        return await fetch(`/${type}`, {
            method: 'post',
            headers: {
                'X-CSRF-TOKEN': getCsrfToken()
            },
            body: formData
        });
    }
    return await sendAjaxRequest('post', `/${type}`, {content: content});
}
async function submitAddPost(event) {
    event.preventDefault();
    const content = addPostForm.querySelector('input[name="content"]').value;
    const response = await submitAddPostOrComment(addPostForm, {'content': content}, 'post');
    
    // const file = addPostForm.querySelector('input[type=file]').files;
    // let reponse;
    // if (file.length > 0) {
    //     const formData = new FormData();
    //     formData.append('content', content);
    //     formData.append('media', file[0]);
    //     response = await fetch('/post', {
    //         method: 'POST',
    //         headers: {
    //             'X-CSRF-TOKEN': getCsrfToken()
    //         },
    //         body: formData
    //     });
    // }
    // else response = await sendAjaxRequest('post', '/post', {content: content});

    console.log(response)
    if (response.ok) {
        const data = await response.json();
        console.log(data);
        
        // const addPostTextField = addPostForm.querySelector('input[name="content"]');
        // addPostTextField.value = '';
        addPostForm.reset();
        
        // addPost(<container>, <post_info>)
    }
    else {
        console.log('Error: ' + response.status);
    }
}
