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
    if (searchValue == "") {
        showFeedback('Please enter text to search');
        return;
    }
    const type = getSearchType();
    console.log("sending to " + type);
    const data = await sendAjaxRequest('get', `/api/${type}/search?${encodeForAjax({query: searchValue})}`);
    console.log(data);
    // Change the URL so the user can share the search results (or save them)
    const encodedSearchValue = encodeURIComponent(searchValue); // Encode special characters
    const newUrl = window.location.href.split('?')[0] + '?query=' + encodedSearchValue;

    history.replaceState(null, null, newUrl); // Replace current URL without reloading page

    
    if (data != null) {
        resultsContainer.innerHTML = '';
        data.resultsHTML.forEach(element => {
            const elementHTML = parseHTML(element);
            resultsContainer.appendChild(elementHTML);
        });
        if (data.resultsHTML.length == 0) {
            resultsContainer.appendChild(parseHTML(data.noResultsHTML));
        }
        searchForm.reset();     // clear the search bar
    }
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
