import { destroyFetcher, infiniteScroll } from '../infinite_scrolling.js'
import { parseHTML } from '../general_helpers.js'
import { addFollowRequestEvents, addGroupInvitationEvents } from '../notifications/notifications.js'

const container = document.querySelector('#notifications-home-container')
const fetcher = document.querySelector('#notifications-home-fetcher')
let observer = null

if (container && fetcher) {
  const firstAction = data => {
    if (data.notifications.length == 0) {
      container.innerHTML = `<p class="text-center">No notifications yet</p>`
      return
    }
    appendNotifications(data.notifications)
  }
  const action = data => {
    appendNotifications(data.notifications)
    if (data.notifications.length == 0) {
      destroyFetcher(observer)
    }
  }
  observer = await infiniteScroll(
    container,
    fetcher,
    `/api/notifications`,
    firstAction,
    action,
    true,
    false
  )
}

async function appendNotifications (notifications) {
  for (const notification of notifications) {
    const notificationElement = parseHTML(notification)
    container.insertBefore(notificationElement, fetcher)

    if (notificationElement.dataset.type === 'follow-request') {
      addFollowRequestEvents(notificationElement)
    }
    else if (notificationElement.dataset.type === 'Request') {

    }
    else if (notificationElement.dataset.type === 'Invitation') {
      addGroupInvitationEvents(notificationElement);
    }
  }
}
