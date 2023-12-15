import { destroyFetcher, infiniteScroll } from '../infinite_scrolling.js'
import { parseHTML } from '../general_helpers.js'
import { toggleLike } from '../posts/like.js'

const container = document.querySelector('#profile-page #posts-container')
const testIntersectionElement = document.querySelector('#fetcher')

if (container && testIntersectionElement) {
  // only if on the profile page
  const userId = container.dataset.id
  const firstAction = data => {
    if (data.postsHTML.length == 0) {
      container.innerHTML = `<p class="no-posts">No posts yet</p>`
      return
    }
    appendPosts(data.postsHTML)
  }
  const action = data => {
    appendPosts(data.postsHTML)
    if (data.postsHTML.length == 0) {
      destroyFetcher()
    }
  }
  infiniteScroll(
    container,
    testIntersectionElement,
    `/api/profile/${userId}/posts`,
    firstAction,
    action,
    true,
    true
  )
}

function appendPosts (postsHTML) {
  for (const postHTML of postsHTML) {
    const postElement = parseHTML(postHTML)
    container.insertBefore(postElement, testIntersectionElement)
    const likeButtons = postElement.querySelectorAll('.like-button')
    if (!likeButtons) return
    for (const likeButton of likeButtons) {
      likeButton.addEventListener('click', async () => {
        toggleLike(likeButton)
      })
    }
  }
}
