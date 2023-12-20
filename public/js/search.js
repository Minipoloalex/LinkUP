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
  const searchValue = getUrlParameter('query') ?? ''
  const type = getUrlParameter('type') ?? 'users'
  const filters = getAdvancedFiltersFromURL(type)
  changeAdvancedFiltersEnabled(convertTypeToIndex(type))

  const anyEnabled = Object.values(filters).some(filter => {
    return filter.value != null && filter.value != '' && filter.value != 'false'
  })

  if (anyEnabled) {
    setAdvancedFilters(type, filters)
  }
  const searchForm = getSearchForm()
  getSearchTextElement(searchForm).value = searchValue

  const searchFilters = getSearchTypeElement()
  const typeRadio = searchFilters.querySelector(`input[value="${type}"]`)
  if (typeRadio) {
    typeRadio.checked = true
  }
  getSearchButton(searchForm).click()
}

async function updateSearchResults (event) {
  event.preventDefault()
  let infiniteScroller = null

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
  const firstAction = async data => {
    resultsContainer.innerHTML = ''
    if (data.resultsHTML.length == 0) {
      resultsContainer.appendChild(parseHTML(data.noResultsHTML))
      await destroyFetcher(infiniteScroller)
    } else {
      appendResults(data.resultsHTML, attachEventListeners)
    }
  }
  const action = async data => {
    if (data.resultsHTML.length == 0) {
      await destroyFetcher(infiniteScroller)
    } else {
      appendResults(data.resultsHTML, attachEventListeners)
    }
  }
  requestData['query'] = searchValue
  infiniteScroller = await infiniteScroll(
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
  setUrlSearchParameters(searchValue, type)
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
  const date = filtersWrapper.querySelector('input[type="date"]')

  const data = {}
  for (const checkbox of checkboxes) {
    data[checkbox.getAttribute('name')] = checkbox.checked
  }
  if (date) {
    data[date.getAttribute('name')] = date.value
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
      searchButton.click()
    })
  }
}

function changeAdvancedFiltersEnabled(toShow) {
  for (let j = 0; j < 4; j++) {
    if (toShow == j) {
      filters[j].classList.remove('hidden')
      filters[j].classList.add('filter-selected')
      continue
    }
    filters[j].classList.add('hidden')
    filters[j].classList.remove('filter-selected')
  }
}

function setUrlSearchParameters(searchValue, type) {
  const searchForm = getSearchForm()
  const filtersWrapper = getAdvancedFiltersWrapper(searchForm, type)
  const data = getAdvancedFiltersData(filtersWrapper)
  data['query'] = searchValue
  data['type'] = type
  setUrlParameters(data)
}

function buildFilter(name) {
  return {
    name: name,
    value: getUrlParameter(name)
  }
}
function getAdvancedFiltersFromURL(type) {
  switch(type) {
    case 'users':
      return [
        buildFilter('exact-match'),
        buildFilter('user-filter-followers'),
        buildFilter('user-filter-following'),
      ]
    case 'groups':
      return [
        buildFilter('exact-match'),
        buildFilter('group-filter-owner'),
        buildFilter('group-filter-not-member'),
      ]
    default:
      return [
        buildFilter('post-filter-likes'),
        buildFilter('post-filter-comments'),
        buildFilter('post-filter-date'),
      ]
  }
}
function convertTypeToIndex(type) {
  switch(type) {
    case 'users':
      return 0
    case 'groups':
      return 1
    case 'posts':
      return 2
    default:
      return 3
  }
}

function setAdvancedFilters(type, filters) {
  const filtersWrapper = getAdvancedFiltersWrapper(getSearchForm(), type)
  for (const filter of filters) {
    const input = filtersWrapper.querySelector(`input[name="${filter.name}"]`)
    if (input.getAttribute('type') === 'date') {
      input.value = filter.value
    }
    else {
      input.checked = filter.value === 'true'
    }
  }
  const index = convertTypeToIndex(type)
  changeAdvancedFiltersEnabled(index)
  showAdvancedFilters()
}

const advancedSearchButton = document.querySelector('#advanced-search-button')
const advancedFilters = document.querySelector('#advanced-filters')

if (advancedSearchButton && advancedFilters) {
  advancedSearchButton.addEventListener('click', () => {
    advancedSearchButton.classList.toggle('text-dark-active')
    advancedFilters.classList.toggle('advanced-inactive')
  })
}

function showAdvancedFilters() {
  advancedFilters.classList.remove('advanced-inactive')
}

const userFilters = document.querySelector('#user-filters')
const groupFilters = document.querySelector('#group-filters')
const postFilters = document.querySelector('#post-filters')
const commentFilters = document.querySelector('#comment-filters')

const filters = [userFilters, groupFilters, postFilters, commentFilters]
const tabs = getSearchTypeElement().querySelector('ul')

if (userFilters && groupFilters && tabs) {
  for (let i = 0; i < 4; i++) {
    const tab = tabs.children[i]
    tab.addEventListener('click', () => changeAdvancedFiltersEnabled(i))
  }
}

const resultsContainer = document.querySelector(
  '#search-page #results-container'
)
if (resultsContainer) {
  // only if on the search page
  const searchForm = getSearchForm()
  const searchButton = getSearchButton(searchForm)
  const advancedFiltersInputs = document.getElementById('advanced-filters').querySelectorAll('input')

  searchForm.addEventListener('submit', updateSearchResults)
  searchButton.addEventListener('click', updateSearchResults)
  initSearchResults()
  updateOnFilterChange()
  advancedFiltersInputs.forEach(filter => {
    filter.addEventListener('change', () => {
      searchButton.click()
    })
  })
}
