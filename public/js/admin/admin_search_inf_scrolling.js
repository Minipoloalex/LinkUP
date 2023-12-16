import { getSearchForm, getSearchTextElement } from '../search.js';
import { infiniteScroll, destroyFetcher } from '../infinite_scrolling.js';

export async function addInfiniteScrollToAdmin(container, testIntersectionElement, url, getElement, addEventListeners = null) {
    const searchForm = getSearchForm();
    const query = {query: getSearchTextElement(searchForm).value};

    const insert = async (data) => {
        for (const html of data.resultsHTML) {
            const element = getElement(html);
            container.appendChild(element);
            if (addEventListeners != null) {
                addEventListeners(element);
            }
        }
        if (data.resultsHTML.length == 0) {
            await destroyFetcher();
        }
    }
    const firstAction = async (data) => {
        container.innerHTML = '';
        await insert(data);
    };
    const action = async (data) => {
        await insert(data);
    };
    
    await infiniteScroll(container, testIntersectionElement, url, firstAction, action, true, true, query ?? {});
}

export async function addEventListenersToSearchForm(container, testIntersectionElement, url, getElement) {
    const searchForm = getSearchForm();
    const updateSearchResults = async (event) => {
        event.preventDefault();
        await addInfiniteScrollToAdmin(container, testIntersectionElement, url, getElement, null);
    }
    searchForm.addEventListener('submit', async (event) => await updateSearchResults(event));
    searchForm.addEventListener('input', async (event) => await updateSearchResults(event));
}
