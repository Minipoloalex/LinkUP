import { parseHTML } from '../general_helpers.js';
import { infiniteScroll } from '../infinite_scrolling.js';

const timeline = document.querySelector('#timeline');
export function prependPostsToTimeline(postsHTML) {
  if (timeline) {
    for (const postHTML of postsHTML) {
      const postElement = parseHTML(postHTML);
      timeline.insertBefore(postElement, timeline.firstChild);
    }
  }
}
function appendPostsToTimeline(postsHTML) {
  if (timeline) {
    for (const postHTML of postsHTML) {
      const postElement = parseHTML(postHTML);
      timeline.insertBefore(postElement, timeline.lastElementChild);
    }
  }
}

if (timeline) {
  const testIntersectionElement = timeline.querySelector('#fetcher');
  const action = (data) => appendPostsToTimeline(data.resultsHTML);
  infiniteScroll(timeline, testIntersectionElement, '/api/posts/timeline', action, action);
}
