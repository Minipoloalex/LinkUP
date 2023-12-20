import {
  parseHTML,
  setUrlParameters,
  getUrlParameter
} from './general_helpers.js'
import { showFeedback } from './feedback.js'
import { destroyFetcher, infiniteScroll } from './infinite_scrolling.js'
import { addEventListenersToPost } from './posts/post_event_listeners.js'

const searchbarRight = document.querySelector('#search-home')

if (searchbarRight) {
  searchbarRight.classList.add('hidden')
}

async function initSearchResults () {
  // make the search URLs copiable (check them after loading the page)
  const searchValue = getUrlParameter('query')
  const type = getUrlParameter('type') ?? 'users'
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

  const type = getSearchType()
  if (type == null) {
    return
  }
  const filtersWrapper = getAdvancedFiltersWrapper(searchForm, type)
  const requestData = getAdvancedFiltersData(filtersWrapper)


  let attachEventListeners = null
  if (type == 'posts' || type == 'comments') {
    attachEventListeners = addEventListenersToPost
  }
  const firstAction = data => {
    resultsContainer.innerHTML = ''
    if (data.resultsHTML.length == 0) {
      resultsContainer.appendChild(parseHTML(data.noResultsHTML))
    } else {
      appendResults(data.resultsHTML, attachEventListeners)
    }
  }
  const action = data => {
    if (data.resultsHTML.length == 0) {
      destroyFetcher()
    } else {
      appendResults(data.resultsHTML, attachEventListeners)
    }
  }
  requestData['query'] = searchValue
  console.log(requestData)
  infiniteScroll(
    resultsContainer,
    testIntersectionElement,
    `/api/${type}/search`,
    firstAction,
    action,
    true,
    true,
    requestData
  )

  // Change the URL so the user can share the search results (or save them)
  setUrlParameters({
    query: searchValue,
    type: type
  })
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
function getAdvancedFiltersWrapper(form, type) {
  switch (type) {
    case 'users':
      return form.querySelector('#user-filters')
    case 'groups':
      return form.querySelector('#group-filters')
    case 'posts':
      return form.querySelector('#post-filters')
    default:  // 'comments'
      return form.querySelector('#comment-filters')
  }
}
function getAdvancedFiltersData(filtersWrapper) {
  const checkboxes = filtersWrapper.querySelectorAll('input[type="checkbox"]')
  console.log(filtersWrapper)
  console.log(checkboxes)

  const data = {}
  for (const checkbox of checkboxes) {
    console.log(checkbox)
    console.log(checkbox.getAttribute('name'))
    data[checkbox.getAttribute('name')] = checkbox.checked
  }
  return data
}
function appendResults (results, attachEventListeners = null) {
  results.forEach(result => {
    const resultHTML = parseHTML(result)
    resultsContainer.appendChild(resultHTML)
    if (attachEventListeners) {
      attachEventListeners(resultHTML)
    }
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

const advancedSearchButton = document.querySelector('#advanced-search-button')
const advancedFilters = document.querySelector('#advanced-filters')

if (advancedSearchButton && advancedFilters) {
  advancedSearchButton.addEventListener('click', () => {
    advancedSearchButton.classList.toggle('text-dark-active')
    advancedFilters.classList.toggle('advanced-inactive')
  })
}

const userFilters = document.querySelector('#user-filters')
const groupFilters = document.querySelector('#group-filters')
const postFilters = document.querySelector('#post-filters')
const commentFilters = document.querySelector('#comment-filters')

const filters = [userFilters, groupFilters, postFilters, commentFilters]
const tabs = getSearchTypeElement().querySelector('ul')

if (userFilters && groupFilters && tabs) {
  console.log(tabs.children)
  for (let i = 0; i < 4; i++) {
    const tab = tabs.children[i]
    tab.addEventListener('click', () => {
      for (let j = 0; j < 4; j++) {
        if (i == j) {
          filters[j].classList.remove('hidden')
          filters[j].classList.add('filter-selected')
          continue
        }
        filters[j].classList.add('hidden')
        filters[j].classList.remove('filter-selected')
      }
    })
  }
}
