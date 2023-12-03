const resultsContainer = document.querySelector('#searchpage #results-container');
if (resultsContainer) {   // only if on the search page
    const searchForm = getSearchForm();
    const searchButton = searchForm.querySelector('button[type="submit"]');
    searchForm.addEventListener('submit', updateSearchResults);
    searchButton.addEventListener('click', updateSearchResults);
}
function getSearchForm() {
    return document.querySelector('#search-form');
}
async function updateSearchResults(event) {
    event.preventDefault();
    const searchForm = getSearchForm();
    const searchValue = searchForm.querySelector('#search-text').value;
    if (searchValue == "") {
        showFeedback('Please enter text to search');
        return;
    }
    
    const data = await sendAjaxRequest('get', `/api/post/search/${searchValue}`);
    
    // Change the URL so the user can share the search results (or save them)
    const encodedSearchValue = encodeURIComponent(searchValue); // Encode special characters
    const newUrl = window.location.href.split('?')[0] + '?query=' + encodedSearchValue;

    history.replaceState(null, null, newUrl); // Replace current URL without reloading page
    
    
    if (data != null) {
        resultsContainer.innerHTML = '';
        data.postsHTML.forEach(element => {
            const postHTML = parseHTML(element);
            resultsContainer.appendChild(postHTML);
        });
        if (data.postsHTML.length == 0) {
            resultsContainer.innerHTML = '<p class="flex justify-center">No results found</p>';
        }
        searchForm.reset();     // clear the search bar
    }
}
