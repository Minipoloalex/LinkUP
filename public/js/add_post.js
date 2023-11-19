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
