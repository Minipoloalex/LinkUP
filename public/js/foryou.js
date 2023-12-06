import { getCsrfToken } from './ajax.js';
import { parseHTML } from './general_helpers.js';

function appendPostsToTimeline(postsHTML) {
  const timeline = document.querySelector('#for-you-timeline');

  for (const postHTML of postsHTML) {
    const postElement = parseHTML(postHTML);
    timeline.insertBefore(postElement, timeline.lastElementChild);
  }
}   

/*export function prependPostsToTimeline(postsHTML) {
  const timeline = document.querySelector('#for-you-timeline')
  console.log(postsHTML);

  for (const postHTML of postsHTML) {
    const postElement = parseHTML(postHTML);
    timeline.insertBefore(postElement, timeline.firstChild);
  }
}*/


async function fetchForYouPosts() {
    try {
      const response = await fetch('/foryou', {
        method: 'GET',
        headers: {
          'X-CSRF-TOKEN': getCsrfToken(),
          'Content-Type': 'application/x-www-form-urlencoded'
        }
      });
      
      if (!response.ok) {
        throw new Error('Failed to fetch for-you posts');
      }
  
      const posts = await response.json();
      console.log(posts);
      appendPostsToTimeline(posts);
    } catch (error) {
      console.error('Error fetching for-you posts:', error.message);
    }
  }
  


/*
function getCurrentFormattedTime() {
  const currentDate = new Date();

  const year = currentDate.getFullYear();
  const month = String(currentDate.getMonth() + 1).padStart(2, '0');
  const day = String(currentDate.getDate()).padStart(2, '0');
  const hours = String(currentDate.getHours()).padStart(2, '0');
  const minutes = String(currentDate.getMinutes()).padStart(2, '0');
  const seconds = String(currentDate.getSeconds()).padStart(2, '0');

  return `${year}-${month}-${day} ${hours}:${minutes}:${seconds}`;
}*/

// export function fetchNewPosts() {
/*async function fetchNewPosts() {
  // date must be in format YYYY-MM-DD
  const date = getCurrentFormattedTime();
  const posts = await fetchPosts(date);
  prependPostsToTimeline(posts);
}*/

// export function fetchMorePosts() {
    /*
function fetchMorePosts() {
  const timeline = document.querySelector('#timeline');
  const lastPost = timeline.lastElementChild.previousElementSibling; // last element is the fetcher
  const posts = fetchForYouPosts(lastPost.dataset.postDate);
  appendPostsToTimeline(posts)
}*/

function createPostFetcher() {
  const fetcher = document.querySelector('#for-you-timeline-fetcher');
  const observer = new IntersectionObserver(entries => {
    if (entries[0].isIntersecting) {
      fetchForYouPosts();
    }
  })
  observer.observe(fetcher);
}

createPostFetcher();




