import { destroyFetcher, infiniteScroll } from '../infinite_scrolling.js'
import { parseHTML } from '../general_helpers.js'
import { addEventListenersToPost } from '../posts/post_event_listeners.js'

function resolveMemberRequest (group, member_id, element, accept) {
  const url = `/group/${group}/request/${member_id}`

  fetch(url, {
    method: 'POST',
    headers: {
      'Content-Type': 'application/json',
      'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
    },
    body: JSON.stringify({
      accept: accept
    })
  })
    .then(data => {
      if (data.status === 200) {
        parent = element.parentElement
        parent.innerHTML = accept === 'accept' ? 'Accepted' : 'Rejected'
      }
    })
    .catch(error => console.error(error))
}

function addResolveMemberRequestEvents () {
  const accepts = document.querySelectorAll('.member-accept')
  const rejects = document.querySelectorAll('.member-reject')

  if (!accepts || !rejects) return

  const requests = [...accepts, ...rejects]

  for (const request of requests) {
    const user = request.dataset.user
    const group = request.dataset.group

    if (request.classList.contains('member-accept')) {
      request.addEventListener('click', () => {
        resolveMemberRequest(group, user, request, 'accept')
      })
    } else {
      request.addEventListener('click', () => {
        resolveMemberRequest(group, user, request, 'reject')
      })
    }
  }
}

function resolveFollowRequest (user, element, accept) {
  const route = accept === 'accept' ? 'accept' : 'deny'
  const method = accept === 'accept' ? 'PATCH' : 'DELETE'
  const url = `/follow/request/${route}/${user}`

  fetch(url, {
    method: method,
    headers: {
      'Content-Type': 'x-www-form-urlencoded',
      'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
    }
  })
    .then(data => {
      if (data.status === 200) {
        parent = element.parentElement
        parent.innerHTML = accept === 'accept' ? 'Accepted' : 'Rejected'
      }
    })
    .catch(error => console.error(error))
}

function addFollowRequestEvents () {
  const accepts = document.querySelectorAll('.follow-accept')
  const rejects = document.querySelectorAll('.follow-reject')

  if (!accepts || !rejects) return

  const requests = [...accepts, ...rejects]

  for (const request of requests) {
    const user = request.dataset.user

    if (request.classList.contains('follow-accept')) {
      request.addEventListener('click', () => {
        resolveFollowRequest(user, request, 'accept')
      })
    } else {
      request.addEventListener('click', () => {
        resolveFollowRequest(user, request, 'reject')
      })
    }
  }
}

addResolveMemberRequestEvents()
addFollowRequestEvents()

const notificationsTab = document.getElementById('notifications-tab')
if (notificationsTab) {
  notificationsTab.classList.add('hidden')
}
