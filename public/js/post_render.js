import { parseHTML } from './general_helpers.js'

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

function fetchPosts (date) {
  const request = new XMLHttpRequest()
  request.open('GET', `/api/posts/${date}`, false)
  request.setRequestHeader(
    'X-CSRF-TOKEN',
    document.querySelector('meta[name="csrf-token"]').content
  )
  request.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded')
  request.send()

  return JSON.parse(request.responseText)
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
