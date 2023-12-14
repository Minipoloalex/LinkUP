import { getCsrfToken } from '../ajax.js'

export async function toggleLike (button) {
  const icon = button.querySelector('i')
  if (icon.classList.contains('liked')) {
    icon.classList.remove('liked')
    icon.classList.add('unliked')
    icon.classList.remove('fas')
    icon.classList.add('far')
  } else {
    icon.classList.remove('unliked')
    icon.classList.add('liked')
    icon.classList.remove('far')
    icon.classList.add('fas')
  }

  const postId = button.getAttribute('data-id')
  await fetch(`/post/${postId}/like`, {
    method: 'POST',
    headers: {
      'Content-Type': 'application/json',
      'X-CSRF-TOKEN': getCsrfToken()
    }
  })
    .then(response => response.json())
    .then(data => {
      const likeCount = button.parentElement.querySelector('span')
      likeCount.textContent = data.count
    })
}
