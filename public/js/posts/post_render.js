import { getCsrfToken } from '../ajax.js'
import { parseHTML } from '../general_helpers.js'

function appendPostsToTimeline (postsHTML) {
  const timeline = document.querySelector('#timeline')

  for (const postHTML of postsHTML) {
    const postElement = parseHTML(postHTML)
    timeline.insertBefore(postElement, timeline.lastElementChild)
  }
}

function prependPostsToTimeline (postsHTML) {
  const timeline = document.querySelector('#timeline')

  for (const postHTML of postsHTML) {
    const postElement = parseHTML(postHTML)
    timeline.insertBefore(postElement, timeline.firstChild)
  }
}

async function fetchPosts(date) {
  const response = await fetch(`/api/posts/${date}`, {
    method: 'GET',
    headers: {
      'X-CSRF-TOKEN': getCsrfToken(),
      'Content-Type': 'application/x-www-form-urlencoded'
    }
  });

  return await response.json();
}

// export function fetchNewPosts() {
function fetchNewPosts () {
  // date must be in format YYYY-MM-DD
  const date = new Date().toISOString().slice(0, 10)
  const posts = fetchPosts(date)
  prependPostsToTimeline(posts)
}

// export function fetchMorePosts() {
function fetchMorePosts () {
  const timeline = document.querySelector('#timeline')
  const lastPost = timeline.lastElementChild.previousElementSibling // last element is the fetcher
  const posts = fetchPosts(lastPost.dataset.postDate)
  appendPostsToTimeline(posts)
}

function createPostFetcher () {
  const fetcher = document.querySelector('#fetcher')
  const observer = new IntersectionObserver(entries => {
    if (entries[0].isIntersecting) {
      fetchMorePosts()
    }
  })
  observer.observe(fetcher)
}

fetchNewPosts()
createPostFetcher()
