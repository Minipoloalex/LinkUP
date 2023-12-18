import { parseHTML } from '../general_helpers.js';
import { addInfiniteScrollToAdmin, addEventListenersToSearchForm, initAdminSearch } from './admin_search_inf_scrolling.js';

const usersContainer = document.querySelector('#container-admin-users');
const fetcherUsers = document.querySelector('#fetcher-admin-users');

if (usersContainer && fetcherUsers) {
    initAdminSearch();
    const url = '/admin/api/users';
    const parser = (html) => parseHTML(html).querySelector('.user-tr');
    addInfiniteScrollToAdmin(usersContainer, fetcherUsers, url, parser, null);
    addEventListenersToSearchForm(usersContainer, fetcherUsers, url, parser);
}
