import { parseHTML } from '../general_helpers.js'
import {
  addInfiniteScrollToAdmin,
  addEventListenersToSearchForm,
  initAdminSearch
} from './admin_search_inf_scrolling.js'

const groupsContainer = document.querySelector('#container-admin-groups')
const fetcherGroups = document.querySelector('#fetcher-admin-groups')

if (groupsContainer && fetcherGroups) {
  initAdminSearch()
  const url = '/admin/api/groups'
  const parser = html => parseHTML(html).querySelector('.group-tr')
  addInfiniteScrollToAdmin(
    groupsContainer,
    fetcherGroups,
    url,
    parser,
    eventListeners
  )
  addEventListenersToSearchForm(groupsContainer, fetcherGroups, url, parser)
}

function eventListeners (element) {
  const form = element.querySelector('form')

  form.addEventListener('submit', () => {
    form.classList.add('invisible')

    const div = document.createElement('div')
    div.classList.add('spinner-container')
    div.innerHTML = `<i class="fa-solid fa-spinner spinner"></i>`

    element.appendChild(div)
  })
}
