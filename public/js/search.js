import { encodeForAjax, sendAjaxRequest } from "./ajax.js";
import { parseHTML } from "./general_helpers.js";
import { showFeedback } from "./feedback.js";
import { destroyFetcher, infiniteScroll } from "./infinite_scrolling.js";

const resultsContainer = document.querySelector('#search-page #results-container');
if (resultsContainer) {   // only if on the search page
    const searchForm = getSearchForm();
    const searchButton = searchForm.querySelector('button[type="submit"]');

    searchForm.addEventListener('submit', updateSearchResults);
    searchButton.addEventListener('click', updateSearchResults);
}
async function updateSearchResults(event) {
    event.preventDefault();
    const searchForm = getSearchForm();
    const searchValue = searchForm.querySelector('#search-text').value;

    const testIntersectionElement = document.querySelector('#fetcher');
    if (searchValue == "") {
        showFeedback('Please enter text to search');
        return;
    }
    
    const type = getSearchType();
    if (type == null) {
        return;
    }
    const firstAction = (data) => {
        resultsContainer.innerHTML = '';
        searchForm.reset();     // clear the search bar
        if (data.resultsHTML.length == 0) {
            resultsContainer.appendChild(parseHTML(data.noResultsHTML));
        }
        else {
            appendResults(data.resultsHTML);
        }
    }
    const action = (data) => {
        if (data.resultsHTML.length == 0) {
            destroyFetcher();
        }
        else {
            appendResults(data.resultsHTML);
        }
    }
    infiniteScroll(resultsContainer, testIntersectionElement, `/api/${type}/search`, firstAction, action, {
        query: searchValue
    });

    // const data = await sendAjaxRequest('get', `/api/${type}/search?${encodeForAjax({query: searchValue})}`);

    // TODO: Fix this to also include the type
    // Change the URL so the user can share the search results (or save them)
    // const encodedSearchValue = encodeURIComponent(searchValue); // Encode special characters
    // const newUrl = window.location.href.split('?')[0] + '?query=' + encodedSearchValue;

    // history.replaceState(null, null, newUrl); // Replace current URL without reloading page
    
    // if (data != null) {
    //     data.resultsHTML.forEach(element => {
    //         const elementHTML = parseHTML(element);
    //         resultsContainer.appendChild(elementHTML);
    //     });
    //     if (data.resultsHTML.length == 0) {
    //         resultsContainer.appendChild(parseHTML(data.noResultsHTML));
    //     }
    //     searchForm.reset();     // clear the search bar
    // }
}
function getSearchForm() {
    return document.querySelector('#search-form');
}
function getSearchType() {
    const filters = document.querySelector('#search-page #search-filters');
    if (filters) {
        const selected = filters.querySelector('input[name="search-type"]:checked');
        if (selected) {
            return selected.getAttribute('value');
        }
        showFeedback('Please select something to search for');
    }
    return null;
}
function appendResults(results) {
    results.forEach(result => {
        const resultHTML = parseHTML(result);
        resultsContainer.appendChild(resultHTML);
    });
}
