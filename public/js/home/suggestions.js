import { destroyFetcher, infiniteScroll } from '../infinite_scrolling.js'
import { parseHTML } from '../general_helpers.js'

const container = document.querySelector('#suggestions-home-container')
const fetcher = document.querySelector('#suggestions-home-fetcher')

if (container && fetcher) {
  const firstAction = data => {
    if (data.suggestions.length == 0) {
      container.innerHTML = `<p class="no-suggestions">No suggestions yet</p>`
      return
    }
    appendsuggestions(data.suggestions)
  }
  const action = data => {
    appendsuggestions(data.suggestions)
    if (data.suggestions.length == 0) {
      destroyFetcher()
    }
  }
  infiniteScroll(
    container,
    fetcher,
    `/api/suggestions`,
    firstAction,
    action,
    true,
    false
  )
}

function appendsuggestions (suggestions) {
  for (const suggestion of suggestions) {
    const suggestionElement = parseHTML(suggestion)
    container.insertBefore(suggestionElement, fetcher)
  }
}
