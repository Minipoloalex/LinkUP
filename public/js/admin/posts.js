import { addInfiniteScrollToAdmin, addEventListenersToSearchForm } from './admin_search_inf_scrolling.js';
import { parseHTML } from '../general_helpers.js';

const postsContainer = document.querySelector('#container-admin-posts');
const fetcherPosts = document.querySelector('#fetcher-admin-posts');

if (postsContainer && fetcherPosts) {
    const url = '/admin/api/posts';
    const parser = parseHTML;
    addInfiniteScrollToAdmin(postsContainer, fetcherPosts, url, parser);
    addEventListenersToSearchForm(postsContainer, fetcherPosts, url, parser);
}
