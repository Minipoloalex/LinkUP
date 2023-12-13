import { destroyFetcher, infiniteScroll } from '../infinite_scrolling.js';
import { parseHTML } from '../general_helpers.js';

const usersContainer = document.querySelector('#container-admin-users');
const searchForm = document.querySelector('#search-form');
if (usersContainer && searchForm) {
    const updateSearchResults = (event) => {
        event.preventDefault();
        const searchValue = searchForm.querySelector('#search-text').value;
        console.log(searchValue);
        addInfiniteScrollToUsers({query: searchValue});
    };
    searchForm.addEventListener('submit', updateSearchResults);
    searchForm.addEventListener('input', updateSearchResults);
    addInfiniteScrollToUsers(null);
}
function addInfiniteScrollToUsers(query) {
    const fetcher = document.querySelector('#fetcher-admin-users');
    const insert = (data) => {
        for (const postHTML of data.usersHTML) {
            const post = parseHTML(postHTML);
            usersContainer.appendChild(post.querySelector('.user-tr'));
        }
        if (data.usersHTML.length == 0) {
            destroyFetcher();
        }
    }
    const firstAction = (data) => {
        usersContainer.innerHTML = '';
        insert(data);
    };
    const action = (data) => {
        insert(data);
    };
    infiniteScroll(usersContainer, fetcher, '/admin/api/users', firstAction, action, true, true, query ?? {});
}


// async function updateSearchResults (event) {
//     event.preventDefault()
//     const searchValue = searchForm.querySelector('#search-text').value

//     if (searchValue == '') {
//         showFeedback('Please enter text to search')
//         return
//     }

//     const firstAction = data => {
//       resultsContainer.innerHTML = ''
//       if (data.resultsHTML.length == 0) {
//         resultsContainer.appendChild(parseHTML(data.noResultsHTML))
//       } else {
//         appendResults(data.resultsHTML)
//       }
//     }
//     const action = data => {
//       if (data.resultsHTML.length == 0) {
//         destroyFetcher()
//       } else {
//         appendResults(data.resultsHTML)
//       }
//     }
//     infiniteScroll(
//       resultsContainer,
//       testIntersectionElement,
//       `/admin/api/users`,
//       firstAction,
//       action,
//       true,
//       true,
//       {
//         query: searchValue
//       })
// }
