import { parseHTML } from '../general_helpers.js'
import { infiniteScroll } from '../infinite_scrolling.js'
import { addToggleLikeEventListener } from '../posts/like.js'

const timeline = document.querySelector('#timeline')
const for_you_tab = document.querySelector('#for-you-tab')
const following_tab = document.querySelector('#following-tab')

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
      const likeButtons = postElement.querySelectorAll('.like-button')
      if (!likeButtons) return
      for (const likeButton of likeButtons) {
        addToggleLikeEventListener(likeButton)
      }
    }
  }
}

function buildForYouTimeline () {
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

function buildFollowingTimeline () {
  const testIntersectionElement = timeline.querySelector('#fetcher')
  const action = data => prependPostsToTimeline(data.resultsHTML)
  infiniteScroll(
    timeline,
    testIntersectionElement,
    '/api/posts/following',
    action,
    action,
    true,
    true
  )
}

if (timeline) {
  buildForYouTimeline()
}

if (for_you_tab) {
  for_you_tab.addEventListener('click', () => {
    for_you_tab.classList.add('tab-active')
    following_tab.classList.remove('tab-active')
    timeline.innerHTML = '<div id="fetcher" class="h-16 lg:h-0"></div>'
    buildForYouTimeline()
  })
}

if (following_tab) {
  following_tab.addEventListener('click', () => {
    following_tab.classList.add('tab-active')
    for_you_tab.classList.remove('tab-active')
    timeline.innerHTML = '<div id="fetcher" class="h-16 lg:h-0"></div>'
    //buildFollowingTimeline()
    buildForYouTimeline()
  })
}
