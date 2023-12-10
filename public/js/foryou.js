import { getCsrfToken } from './ajax.js';
import { parseHTML } from './general_helpers.js';
import { initializeLikeButton } from './posts/like.js';
document.addEventListener('DOMContentLoaded', () => {

    function appendPostsToForYouTimeline(postsHTML) {
        const timeline = document.querySelector('#for-you-timeline');

        for (const postHTML of postsHTML) {
            const postElement = parseHTML(postHTML);
            timeline.insertBefore(postElement, timeline.lastElementChild);
            const postId = postElement.getAttribute('data-id');
            const likeButton = postElement.querySelector('.like-button');
            initializeLikeButton(postId, likeButton);
        }
    }   


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
        appendPostsToForYouTimeline(posts);
        } catch (error) {
        console.error('Error fetching for-you posts:', error.message);
        }
    }


    function createForYouPostFetcher() {
        const fetcher = document.querySelector('#for-you-timeline-fetcher');
        if(!fetcher){
            return;
        }
        const observer = new IntersectionObserver(entries => {
            if (entries[0].isIntersecting) {
            fetchForYouPosts();
            }
        })
            console.log(fetcher);
        observer.observe(fetcher);
    }

    createForYouPostFetcher();

});