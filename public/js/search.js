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
    const data = await sendAjaxRequest('get', `/api/post/search/${searchValue}`);
    if (data != null) {
        resultsContainer.innerHTML = '';

        data.forEach(element => {
            addPostToDOM(resultsContainer, element, false);
        });
        if (data.length == 0) {
            resultsContainer.innerHTML = '<p class="flex justify-center">No results found</p>';
        }
        searchForm.reset();     // clear the search bar
    }
}
