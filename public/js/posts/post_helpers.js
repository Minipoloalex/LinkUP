export function getTextField(form) {
  return form.querySelector('textarea')
}
export async function submitAddPostOrComment(form, data, type) {
  // type = 'post' or 'comment'
  return await submitDataPostOrComment(form, data, `/${type}`, 'post')
}
export async function submitDataPostOrComment(form, data, url, method) {
  // includes the file
  const file = form.querySelector('input[type=file]').files;
  if (file.length > 0) {
    const formData = new FormData();
    for (const key in data) {
      formData.append(key, data[key]);
    }
    formData.append('media', file[0]);
    const x = form.querySelector('input[name="x"]');
    const y = form.querySelector('input[name="y"]');
    const width = form.querySelector('input[name="width"]');
    const height = form.querySelector('input[name="height"]');
    formData.append('x', x.value);
    formData.append('y', y.value);
    formData.append('width', width.value);
    formData.append('height', height.value);
    const response = await fetch(url, {
      method: method,
      headers: {
        'X-CSRF-TOKEN': getCsrfToken(),
      },
      body: formData
    });
    return handleFeedbackToResponse(response);
  }
  return await sendAjaxRequest(method, url, data)
}
export function removeImageContainer(post) {
  const imageContainer = post.querySelector('.image-container')
  if (imageContainer) {
    imageContainer.remove()
  }
}
export function incrementCommentCount(post) {
  changeCommentCount(post, 1)
}
export function decrementCommentCount(post) {
  changeCommentCount(post, -1)
}
function changeCommentCount(post, value) {
  const nrComments = post.querySelector('.nr-comments')
  nrComments.textContent = parseInt(nrComments.textContent) + value
}
export async function deleteImage(event) {
  event.preventDefault()
  if (confirm('Are you sure you want to delete this image?')) {
    const button = event.currentTarget
    const postId = button.dataset.id

    const imageContainer = button.closest('.image-container')
    const data = await sendAjaxRequest('delete', `/post/${postId}/image`)
    if (data != null) {
      imageContainer.remove()
    }
  }
}
