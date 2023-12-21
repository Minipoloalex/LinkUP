import { getCsrfToken } from "../ajax.js"

const notificationsTab = document.getElementById('notifications-tab')
const container = document.querySelector('section#notifications-home-container')
if (notificationsTab && container) {
  notificationsTab.classList.add('hidden')
}

function resolveMemberRequest (group, member_id, element, accept) {
  const url = `/group/${group}/request/${member_id}`

  addFollowRequestEvents()
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

export function addFollowRequestEvents (notification) {
  const accepts = notification.querySelectorAll('.follow-accept')
  const rejects = notification.querySelectorAll('.follow-reject')

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

export function addGroupInvitationEvents (notification) {
  const accepts = notification.querySelectorAll('.invitation-accept')
  const rejects = notification.querySelectorAll('.invitation-reject')

  if (!accepts || !rejects) return

  const requests = [...accepts, ...rejects]

  for (const request of requests) {
    if (request.classList.contains('invitation-accept')) {
      request.addEventListener('click', (event) => resolveInvitation(event, 'accept'))
    } else {
      request.addEventListener('click', (event) => resolveInvitation(event, 'reject'))
    } 
  }
}


function addResolveGroupInvitationEvents () {
  const accepts = document.querySelectorAll('.invitation-accept')
  const rejects = document.querySelectorAll('.invitation-reject')

  if (!accepts || !rejects) return

  const requests = [...accepts, ...rejects]

  for (const request of requests) {
    if (request.classList.contains('invitation-accept')) {
      request.addEventListener('click', (event) => resolveInvitation(event, 'accept'))
    } else {
      request.addEventListener('click', (event) => resolveInvitation(event, 'reject'))
    }
  }
}
async function resolveInvitation(event, accept) {
  event.preventDefault()
  const button = event.currentTarget
  const groupId = button.dataset.groupId

  const type = accept === 'accept' ? 'acceptInvitation' : 'denyInvitation'
  const response = await fetch(`/group/${type}/${groupId}`, {
    method: 'PATCH',
    headers: {
      'Content-Type': 'application/json',
      'X-CSRF-TOKEN': getCsrfToken()
    }
  })
  if (response.ok) {
    const data = await response.json()
    if (data.success) {
      parent = button.parentElement
      parent.innerHTML = accept === 'accept' ? 'Accepted' : 'Rejected'
    }
  }
}

addResolveMemberRequestEvents()
addResolveGroupInvitationEvents()
