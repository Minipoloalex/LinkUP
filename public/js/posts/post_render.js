import { parseHTML } from '../general_helpers.js'
import { infiniteScroll } from '../infinite_scrolling.js'
import { initializeLikeButton } from './like.js'

const timeline = document.querySelector('#timeline')
export function prependPostsToTimeline (postsHTML) {
  if (timeline) {
    for (const postHTML of postsHTML) {
      const postElement = parseHTML(postHTML)
      timeline.insertBefore(postElement, timeline.firstChild)
    }
  }
}
function appendPostsToTimeline (postsHTML) {
  if (timeline) {
    for (const postHTML of postsHTML) {
      const postElement = parseHTML(postHTML)
      timeline.insertBefore(postElement, timeline.lastElementChild)
      const postId = postElement.getAttribute('data-id')
      const likeButton = postElement.querySelector('.like-button')
      initializeLikeButton(postId, likeButton)
    }
  }
}

if (timeline) {
  const testIntersectionElement = timeline.querySelector('#fetcher')
  const action = data => appendPostsToTimeline(data.resultsHTML)
  infiniteScroll(
    timeline,
    testIntersectionElement,
    '/api/posts/for-you',
    action,
    action,
    true,
    true
  )
}
