import { getCsrfToken } from '../ajax.js';
import { parseHTML } from '../general_helpers.js';
import { initializeLikeButton } from './like.js';

function appendPostsToTimeline(postsHTML) {
  const timeline = document.querySelector('#timeline');
  for (const postHTML of postsHTML) {
    const postElement = parseHTML(postHTML);
    timeline.insertBefore(postElement, timeline.lastElementChild);
  }
}

export function prependPostsToTimeline(postsHTML) {
  const timeline = document.querySelector('#timeline')

  for (const postHTML of postsHTML) {
    const postElement = parseHTML(postHTML);
    timeline.insertBefore(postElement, timeline.firstChild);
    const postId = postElement.getAttribute('data-id');
    const likeButton = postElement.querySelector('.like-button');
    initializeLikeButton(postId, likeButton);
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



function getCurrentFormattedTime() {
  const currentDate = new Date();

  const year = currentDate.getFullYear();
  const month = String(currentDate.getMonth() + 1).padStart(2, '0');
  const day = String(currentDate.getDate()).padStart(2, '0');
  const hours = String(currentDate.getHours()).padStart(2, '0');
  const minutes = String(currentDate.getMinutes()).padStart(2, '0');
  const seconds = String(currentDate.getSeconds()).padStart(2, '0');

  return `${year}-${month}-${day} ${hours}:${minutes}:${seconds}`;
}

async function fetchNewPosts() {
  // date in format YYYY-MM-DD HH:MM:SS
  const date = getCurrentFormattedTime();
  const posts = await fetchPosts(date);
  prependPostsToTimeline(posts);
}

async function fetchMorePosts() {
  const timeline = document.querySelector('#timeline');
  const lastPost = timeline.lastElementChild.previousElementSibling; // last element is the fetcher
  const posts = await fetchPosts(lastPost.dataset.postDate);
  appendPostsToTimeline(posts);
}

async function createPostFetcher() {
  const fetcher = document.querySelector('#fetcher');
  const observer = new IntersectionObserver(async (entries) => {
    if (entries[0].isIntersecting) {
      await fetchMorePosts();
    }
  })
  observer.observe(fetcher);
}

await fetchNewPosts();
await createPostFetcher();
