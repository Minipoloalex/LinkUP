import { sendAjaxRequest } from "./ajax.js";

function createPostElement(post) {
    const postElement = document.createElement('article');
    postElement.classList.add('post');
    postElement.dataset.postId = post.id;

    const header = document.createElement('header');
    const title = document.createElement('h1');
    title.textContent = post.title;
    header.appendChild(title);
    postElement.appendChild(header);

    const content = document.createElement('p');
    content.textContent = post.content;
    postElement.appendChild(content);

    const footer = document.createElement('footer');
    const author = document.createElement('p');
    author.textContent = post.author;
    footer.appendChild(author);
    postElement.appendChild(footer);

    return postElement;
}

function appendPostsToTimeline(posts) {
    const timeline = document.querySelector('#timeline');

    for (const post of posts) {
        const postElement = createPostElement(post);
        timeline.insertBefore(postElement, timeline.lastElementChild);
    }
    console.log(timeline.lastChild);
}

function prependPostsToTimeline(posts) {
    const timeline = document.querySelector('#timeline');

    for (const post of posts) {
        const postElement = createPostElement(post);
        timeline.insertBefore(postElement, timeline.firstChild);
    }
}

function fetchPosts() {
    // TODO: take date as an argument and fetch posts older than that date
    const request = new XMLHttpRequest();
    request.open('GET', '/api/posts', false);
    request.setRequestHeader('X-CSRF-TOKEN', document.querySelector('meta[name="csrf-token"]').content);
    request.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    request.send();

    return JSON.parse(request.responseText);
}

export function fetchNewPosts() {
    const posts = fetchPosts();
    prependPostsToTimeline(posts);
}

export function fetchMorePosts() {
    const posts = fetchPosts();
    appendPostsToTimeline(posts);
}
