import { getCsrfToken } from '../ajax.js'

export async function addToggleLikeEventListener (button) {
  button.addEventListener('click', async () => {
    await toggleLike(button)
  })
}

async function toggleLike (button) {
  const icon = button.querySelector('i')
  const likeCount = button.parentElement.querySelector('span')
  if (icon.classList.contains('liked')) {
    icon.classList.remove('liked')
    icon.classList.add('unliked')
    icon.classList.remove('fas')
    icon.classList.add('far')
    likeCount.textContent = parseInt(likeCount.textContent) - 1
  } else {
    icon.classList.remove('unliked')
    icon.classList.add('liked')
    icon.classList.remove('far')
    icon.classList.add('fas')
    likeCount.textContent = parseInt(likeCount.textContent) + 1
  }

  const postId = button.getAttribute('data-id')
  const response = await fetch(`/post/${postId}/like`, {
    method: 'POST',
    headers: {
      'Content-Type': 'application/json',
      'X-CSRF-TOKEN': getCsrfToken()
    }
  })
    .then(async response => await response.json())
    .then(data => {
      likeCount.textContent = data.count
    })
}

const posts = document.querySelectorAll('.post')
posts.forEach(post => {
  const likeButtons = post.querySelectorAll('.like-button')
  likeButtons.forEach(addToggleLikeEventListener)
})
