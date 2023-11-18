import * as posts from "./post_render.js";

function createPostFetcher() {
    const fetcher = document.querySelector('#fetcher');
    const observer = new IntersectionObserver((entries) => {
        if (entries[0].isIntersecting) {
            posts.fetchNewPosts();
        }
    });
    observer.observe(fetcher);
}

posts.fetchNewPosts();
createPostFetcher();