import { parseHTML } from '../general_helpers.js';
import { infiniteScroll } from '../infinite_scroll.js';


export function prependPostsToTimeline(postsHTML) {
  const timeline = document.querySelector('#timeline')

  for (const postHTML of postsHTML) {
    const postElement = parseHTML(postHTML);
    timeline.insertBefore(postElement, timeline.firstChild);
  }
}

infiniteScroll(document.querySelector('#timeline'), '/api/posts/timeline');
