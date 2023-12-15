import { encodeForAjax, sendAjaxRequest } from './ajax.js'
import { parseHTML } from './general_helpers.js'
import { showFeedback } from './feedback.js'
import { destroyFetcher, infiniteScroll } from './infinite_scrolling.js'

async function initSearchResults () {
  // make the search URLs copiable
  const urlParams = new URLSearchParams(window.location.search)
  const searchValue = urlParams.get('query')
  const type = urlParams.get('type')
  console.log(searchValue, type)
  if (searchValue != null && type != null) {
    const searchForm = getSearchForm()
    getSearchTextElement(searchForm).value = searchValue

    const searchFilters = getSearchTypeElement()
    const typeRadio = searchFilters.querySelector(`input[value="${type}"]`)
    if (typeRadio) {
      typeRadio.checked = true
    }
    getSearchButton(searchForm).click()
  }
}

async function updateSearchResults (event) {
  event.preventDefault()
  const searchForm = getSearchForm()
  const searchValue = getSearchTextElement(searchForm).value

  const testIntersectionElement = document.querySelector('#fetcher')
  if (searchValue == '') {
    showFeedback('Please enter text to search')
    return
  }

  const type = getSearchType()
  if (type == null) {
    return
  }
  const firstAction = data => {
    resultsContainer.innerHTML = ''
    if (data.resultsHTML.length == 0) {
      resultsContainer.appendChild(parseHTML(data.noResultsHTML))
    } else {
      appendResults(data.resultsHTML)
    }
  }
  const action = data => {
    if (data.resultsHTML.length == 0) {
      destroyFetcher()
    } else {
      appendResults(data.resultsHTML)
    }
  }
  infiniteScroll(
    resultsContainer,
    testIntersectionElement,
    `/api/${type}/search`,
    firstAction,
    action,
    true,
    true,
    {
      query: searchValue
    }
  )

  // Change the URL so the user can share the search results (or save them)
  const newUrl =
    window.location.href.split('?')[0] +
    '?' +
    encodeForAjax({
      query: searchValue,
      type: type
    })
  history.replaceState(null, null, newUrl) // Replace current URL without reloading page
}
export function getSearchForm () {
  return document.querySelector('#search-form')
}
function getSearchButton (searchForm) {
  return searchForm.querySelector('button[type="submit"]')
}
export function getSearchTextElement (searchForm) {
  return searchForm.querySelector('#search-text')
}
function getSearchTypeElement () {
  return document.querySelector('#search-page #search-filters')
}
function getSearchType () {
  const filters = getSearchTypeElement()
  if (filters) {
    const selected = filters.querySelector('input[name="search-type"]:checked')
    if (selected) {
      return selected.getAttribute('value')
    }
    showFeedback('Please select something to search for')
  }
  return null
}
function appendResults (results) {
  results.forEach(result => {
    const resultHTML = parseHTML(result)
    resultsContainer.appendChild(resultHTML)
  })
}
function updateOnFilterChange () {
  const searchForm = getSearchForm()
  const searchButton = getSearchButton(searchForm)
  const filters = getSearchTypeElement()

  for (const filter of filters.querySelectorAll('input[name="search-type"]')) {
    filter.addEventListener('change', () => {
      if (getSearchTextElement(searchForm).value != '') {
        searchButton.click()
      }
    })
  }
}

const resultsContainer = document.querySelector(
  '#search-page #results-container'
)
if (resultsContainer) {
  // only if on the search page
  const searchForm = getSearchForm()
  const searchButton = getSearchButton(searchForm)

  searchForm.addEventListener('submit', updateSearchResults)
  searchButton.addEventListener('click', updateSearchResults)
  initSearchResults()
  updateOnFilterChange()
}
