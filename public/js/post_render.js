function createPostElement(post) {
    const postElement = buildPost(post, false);
    // const postElement = document.createElement('article');
    // postElement.classList.add('post');
    // postElement.dataset.postId = post.id;
    // postElement.dataset.postDate = post.created_at;

    // const header = document.createElement('header');
    // postElement.appendChild(header);

    // const content = document.createElement('p');
    // content.textContent = post.content;
    // postElement.appendChild(content);

    // const footer = document.createElement('footer');
    // const author = document.createElement('p');
    // author.textContent = post.author;
    // footer.appendChild(author);
    // postElement.appendChild(footer);

    // return postElement;
}

function appendPostsToTimeline(posts) {
    const timeline = document.querySelector('#timeline');

    for (const post of posts) {
        const postElement = createPostElement(post);
        timeline.insertBefore(postElement, timeline.lastElementChild);
    }
}

function prependPostsToTimeline(posts) {
    const timeline = document.querySelector('#timeline');

    for (const post of posts) {
        const postElement = createPostElement(post);
        timeline.insertBefore(postElement, timeline.firstChild);
    }
}

function fetchPosts(date) {
    const request = new XMLHttpRequest();
    request.open('GET', `/api/posts/${date}`, false);
    request.setRequestHeader('X-CSRF-TOKEN', document.querySelector('meta[name="csrf-token"]').content);
    request.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    request.send();

    return JSON.parse(request.responseText);
}

export function fetchNewPosts() {
    // date must be in format YYYY-MM-DD
    const date = new Date().toISOString().slice(0, 10);
    const posts = fetchPosts(date);
    prependPostsToTimeline(posts);
}

export function fetchMorePosts() {
    const timeline = document.querySelector('#timeline');
    const lastPost = timeline.lastElementChild.previousElementSibling; // last element is the fetcher
    const posts = fetchPosts(lastPost.dataset.postDate);
    appendPostsToTimeline(posts);
}
