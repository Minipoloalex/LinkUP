import { getCsrfToken } from './ajax.js';
import { parseHTML } from './general_helpers.js';

document.addEventListener('DOMContentLoaded', () => {
  
  function appendPostsToFollowingTimeline(postsHTML) {
    const timeline = document.querySelector('#following-timeline');
  console.log(postsHTML);

    for (const postHTML of postsHTML) {
      console.log(postHTML);
      const postElement = parseHTML(postHTML);
      timeline.insertBefore(postElement, timeline.lastElementChild);
    }
  }  



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
      appendPostsToFollowingTimeline(posts);
    } catch (error) {
      console.error('Error fetching for-you posts:', error.message);
    }
  }
    


  function createFollowingPostFetcher() {
    const fetcher = document.querySelector('#following-timeline-fetcher');
    if(fetcher){
      const observer = new IntersectionObserver(entries => {
        if (entries[0].isIntersecting) {
          fetchFollowingPosts();
        }
      })
      observer.observe(fetcher);
    }
  }

  createFollowingPostFetcher();
  
});




