import { parseHTML } from '../general_helpers.js';
import { addInfiniteScrollToAdmin, addEventListenersToSearchForm } from './admin_search_inf_scrolling.js';

const groupsContainer = document.querySelector('#container-admin-groups');
const fetcherGroups = document.querySelector('#fetcher-admin-groups');

if (groupsContainer && fetcherGroups) {
    const url = '/admin/api/groups';
    const parser = (html) =>  parseHTML(html).querySelector('.group-tr')
    addInfiniteScrollToAdmin(groupsContainer, fetcherGroups, url, parser, () => {});
    addEventListenersToSearchForm(groupsContainer, fetcherGroups, url, parser);
}
