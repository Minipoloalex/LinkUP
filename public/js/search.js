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
    const response = await sendAjaxRequest('get', `/api/post/search/${searchValue}`);
    if (response.ok) {
        const data = await response.json();
        resultsContainer.innerHTML = '';

        console.log(data);
        data.forEach(element => {
            addPostToDom(resultsContainer, element, false);
        });
        if (data.length == 0) {
            resultsContainer.innerHTML = '<p class="flex justify-center">No results found</p>';
        }
        searchForm.reset();     // clear the search bar
    }
    else {
        // display error message to user
        console.log('Error fetching search results');
    }
}
