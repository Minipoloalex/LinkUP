import { destroyFetcher, infiniteScroll } from '../infinite_scrolling.js'
import { parseHTML } from '../general_helpers.js'

const container = document.querySelector('#notifications-home-container')
const fetcher = document.querySelector('#notifications-home-fetcher')

if (container && fetcher) {
  const firstAction = data => {
    if (data.notifications.length == 0) {
      container.innerHTML = `<p class="no-notifications">No notifications yet</p>`
      return
    }
    appendNotifications(data.notifications)
  }
  const action = data => {
    appendNotifications(data.notifications)
    if (data.notifications.length == 0) {
      destroyFetcher()
    }
  }
  infiniteScroll(
    container,
    fetcher,
    `/api/notifications`,
    firstAction,
    action,
    true,
    true
  )
}

function appendNotifications (notifications) {
  for (const notification of notifications) {
    const notificationElement = parseHTML(notification)
    container.insertBefore(notificationElement, fetcher)
  }
}
