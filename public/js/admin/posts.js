import { addInfiniteScrollToAdmin, addEventListenersToSearchForm, initAdminSearch } from './admin_search_inf_scrolling.js';
import { parseHTML } from '../general_helpers.js';
import { addEventListenersToPost } from '../posts/post_event_listeners.js';

const postsContainer = document.querySelector('#container-admin-posts');
const fetcherPosts = document.querySelector('#fetcher-admin-posts');

if (postsContainer && fetcherPosts) {
    initAdminSearch();
    const url = '/admin/api/posts';
    const parser = parseHTML;
    addInfiniteScrollToAdmin(postsContainer, fetcherPosts, url, parser, addEventListenersToPost);
    addEventListenersToSearchForm(postsContainer, fetcherPosts, url, parser);
}
