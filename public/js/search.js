const search = document.querySelector('#search');
const resultsContainer = document.querySelector('#results-container');
const searchForm = document.querySelector('#search-form');
const searchButton = document.querySelector('#search-button');
if (search) {
    searchForm.addEventListener('submit', updateSearchResults);
    searchButton.addEventListener('click', updateSearchResults);
}
async function updateSearchResults(event) {
    event.preventDefault();
    const response = await sendAjaxRequest('get', `/api/post/search/${search.value}`, null);
    if (response.ok) {
        const data = await response.json();
        resultsContainer.innerHTML = '';

        console.log(data);
        // data.forEach(element => {
        //     addPost(element, resultsContainer);
        // });
        if (data.length == 0) {
            resultsContainer.innerHTML = 'No results found';
        }
        search.value = '';  // clear search bar
    }
    else {
        // display error message to user
        console.log('Error fetching search results');
    }
}
