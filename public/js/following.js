import { getCsrfToken } from './ajax.js';
import { parseHTML } from './general_helpers.js';

function appendPostsToTimeline(postsHTML) {
  const timeline = document.querySelector('#following-timeline');
console.log(postsHTML);

  for (const postHTML of postsHTML) {
    console.log(postHTML);
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


async function fetchFollowingPosts() {
  try {
    const response = await fetch('/followingGet', {
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
  


function createPostFetcher() {
  const fetcher = document.querySelector('#following-timeline-fetcher');
  const observer = new IntersectionObserver(entries => {
    if (entries[0].isIntersecting) {
      fetchFollowingPosts();
    }
  })
  observer.observe(fetcher);
}

createPostFetcher();




