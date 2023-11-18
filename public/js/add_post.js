// const toggleAddPost = document.querySelector('.toggle-add-post');
const addPostForm = document.querySelector('form.add-post');
if (addPostForm) {
    addPostForm.addEventListener('submit', submitAddPost);
}

async function submitAddPost(event) {
    event.preventDefault();
    const content = addPostForm.querySelector('input[name="content"]').value;

    const response = await submitAddPostOrComment(addPostForm, {'content': content}, 'post');
    console.log(response)
    if (response.ok) {
        const data = await response.json();
        console.log(data);
        
        addPostForm.reset();
        
        // addPost(<container>, <post_info>)
    }
    else {
        console.log('Error: ' + response.status);
    }
}
async function submitAddPostOrComment(form, data, type) {  // type = 'post' or 'comment'
    return await submitDataPostOrComment(form, data, `/${type}`, 'post');
}

async function submitEditPostOrComment(form, data, postId) {
    // Explains the use of _method https://laravel.com/docs/10.x/routing#form-method-spoofing
    data._method = 'put';
    return await submitDataPostOrComment(form, data, `/post/${postId}`, 'post');
}

async function submitDataPostOrComment(form, data, url, method) {
    // includes the file
    const file = form.querySelector('input[type=file]').files;
    if (file.length > 0) {
        const formData = new FormData();
        for (const key in data) {
            formData.append(key, data[key]);
        }
        formData.append('media', file[0]);
        return await fetch(url, {
            method: method,
            headers: {
                'X-CSRF-TOKEN': getCsrfToken(),
            },
            body: formData
        });
    }
    return await sendAjaxRequest(method, url, data);
}
