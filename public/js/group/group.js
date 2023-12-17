// Path: public/js/group/group.js
import { parseHTML } from '../general_helpers.js'
import { infiniteScroll, destroyFetcher } from '../infinite_scrolling.js'
import { hide, show } from '../general_helpers.js'
import { addEventListenersToPost } from '../posts/post_event_listeners.js'

// const Swal = window.swal

export function getNoneElement(section) {
  return section.querySelector('.none')
}
export function prependInPostSection (postElement) {
  const posts_section = document.getElementById('posts-section')
  if (posts_section) {
    posts_section.prepend(postElement)
    const none = getNoneElement(posts_section)
    hide(none)
  }
}

function appendInSection (
  htmlArray,
  section,
  lastElement,
  attachEventListeners
) {
  for (const html of htmlArray) {
    const element = parseHTML(html)
    section.insertBefore(element, lastElement)
    if (attachEventListeners) {
      attachEventListeners(element) // add event listeners to newly loaded elements
    }
  }
}

function addInfiniteScrollingToSection (
  section,
  fetcher,
  url,
  attachEventListeners
) {
  const none = getNoneElement(section)
  const load = data =>
    appendInSection(data.elementsHTML, section, fetcher, attachEventListeners)

  const firstAction = async data => {
    load(data)
    if (data.elementsHTML.length == 0) {
      show(none)
      await destroyFetcher()
      console.log("destroyed on first")
    }
    else {
      hide(none)
    }
  }
  const action = async data => {
    load(data)
    if (data.elementsHTML.length == 0) {
      await destroyFetcher()
      console.log("destroyed on second")
    }
  }
  infiniteScroll(section, fetcher, url, firstAction, action, false, false)
}

function toggleSections () {
  const posts = document.getElementById('posts')
  const members = document.getElementById('members')
  const requests = document.getElementById('requests')
  if (!posts || !members) return

  const posts_section = document.getElementById('posts-section')
  const members_section = document.getElementById('members-section')
  const requests_section = document.getElementById('requests-section')

  const posts_fetcher = posts_section.querySelector('#fetcher-posts')
  const members_fetcher = members_section.querySelector('#fetcher-members')

  const group_element = document.getElementById('group-id')
  if (!group_element) return
  const group_id = group_element.getAttribute('value')

  addInfiniteScrollingToSection(
    posts_section,
    posts_fetcher,
    `/api/group/${group_id}/posts`,
    addEventListenersToPost
  )
  addInfiniteScrollingToSection(
    members_section,
    members_fetcher,
    `/api/group/${group_id}/members`,
    loadedMember => {
      addRemoveMemberEvents(loadedMember, group_id)
    }
  )

  posts.addEventListener('click', () => {
    posts.classList.add('dark:text-dark-active')
    members.classList.remove('dark:text-dark-active')
    if (requests) requests.classList.remove('dark:text-dark-active')
    show(posts_section)
    hide(members_section)
    hide(requests_section)
  })

  members.addEventListener('click', () => {
    posts.classList.remove('dark:text-dark-active')
    members.classList.add('dark:text-dark-active')
    if (requests) requests.classList.remove('dark:text-dark-active')
    show(members_section)
    hide(posts_section)
    hide(requests_section)
  })

  if (!requests) return
  requests.addEventListener('click', () => {
    posts.classList.remove('dark:text-dark-active')
    members.classList.remove('dark:text-dark-active')
    if (requests) requests.classList.add('dark:text-dark-active')
    show(requests_section)
    hide(posts_section)
    hide(members_section)
  })
}

function removeMember (group, member_id, member) {
  const url = `/group/${group}/member/${member_id}`

  fetch(url, {
    method: 'DELETE',
    headers: {
      'Content-Type': 'application/json',
      'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
    }
  })
    .then(data => {
      if (data.status === 200) {
        member.remove()
      }
    })
    .catch(error => console.error(error))
}

function addRemoveMemberEvents (member, group_id) {
  const name = member.querySelector('h1').textContent
  const button = member.querySelector('.member-remove')

  if (!button) return

  const member_id = button.id

  button.addEventListener('click', () => {
    Swal.fire({
      title: `Remove ${name}?`,
      text: "You won't be able to revert this!",
      icon: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#ff0000',
      cancelButtonColor: '#aaa',
      confirmButtonText: 'Yes, remove.'
    }).then(result => {
      if (result.isConfirmed) {
        Swal.fire('Removed!', `${name} has been removed.`, 'success')
        removeMember(group_id, member_id, member)
      }
    })
  })
}

function leaveGroup (group) {
  const url = `/group/${group}/member/self`

  fetch(url, {
    method: 'DELETE',
    headers: {
      'Content-Type': 'application/json',
      'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
    }
  })
    .then(data => {
      if (data.status === 200) {
        window.location.href = `/group/${group}`
      }
    })
    .catch(error => console.error(error))
}

function addLeaveGroupEvent () {
  const group_element = document.getElementById('group-id')
  if (!group_element) return

  const group = group_element.value
  const button = document.getElementById('leave-group')

  if (!button) return

  button.addEventListener('click', () => {
    Swal.fire({
      title: 'Leave group?',
      text: "You won't be able to revert this!",
      icon: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#ff0000',
      cancelButtonColor: '#aaa',
      confirmButtonText: 'Yes, leave.'
    }).then(result => {
      if (result.isConfirmed) {
        leaveGroup(group)
      }
    })
  })
}

function joinGroup (group, button) {
  const url = `/group/${group}/join`

  fetch(url, {
    method: 'POST',
    headers: {
      'Content-Type': 'application/json',
      'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
    }
  })
    .then(data => {
      if (data.status === 200) {
        const new_button = button.cloneNode(true)
        new_button.id = 'pending-group'
        new_button.classList.remove('bg-blue-500')
        new_button.classList.remove('hover:bg-blue-700')
        new_button.classList.add('bg-yellow-500')
        new_button.classList.add('hover:bg-yellow-700')

        const icon = new_button.querySelector('i')
        icon.classList.remove('fa-users')
        icon.classList.add('fa-clock-rotate-left')

        const text = new_button.querySelector('.button-text')
        text.textContent = 'Pending'

        button.parentNode.replaceChild(new_button, button)
        addCancelJoinGroupEvent()
      }
    })
    .catch(error => console.error(error))
}

function addJoinGroupEvent () {
  const group_element = document.getElementById('group-id')
  if (!group_element) return

  const group = group_element.value
  const button = document.getElementById('join-group')

  if (!button) return

  button.addEventListener('click', () => {
    joinGroup(group, button)
  })
}

function cancelJoinGroup (group, button) {
  const url = `/group/${group}/join`

  fetch(url, {
    method: 'DELETE',
    headers: {
      'Content-Type': 'application/json',
      'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
    }
  })
    .then(data => {
      if (data.status === 200) {
        const new_button = button.cloneNode(true)
        new_button.id = 'join-group'
        new_button.classList.remove('bg-yellow-500')
        new_button.classList.remove('hover:bg-yellow-700')
        new_button.classList.add('bg-blue-500')
        new_button.classList.add('hover:bg-blue-700')

        const icon = new_button.querySelector('i')
        icon.classList.remove('fa-clock-rotate-left')
        icon.classList.add('fa-users')

        const text = new_button.querySelector('.button-text')
        text.textContent = 'Join group'

        button.parentNode.replaceChild(new_button, button)
        addJoinGroupEvent()
      }
    })
    .catch(error => console.error(error))
}

function addCancelJoinGroupEvent () {
  const group_element = document.getElementById('group-id')
  if (!group_element) return

  const group = group_element.value
  const button = document.getElementById('pending-group')

  if (!button) return

  button.addEventListener('click', () => {
    cancelJoinGroup(group, button)
  })
}

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
        element.innerHTML = accept === 'accept' ? 'Accepted' : 'Rejected'
      }
    })
    .catch(error => console.error(error))
}

function addResolveMemberRequestEvents () {
  const group_element = document.getElementById('group-id')
  if (!group_element) return

  const group = group_element.value
  const requests = document.querySelectorAll('#requests-section > div > div')
  if (!requests) return

  for (const request of requests) {
    const accept = request.querySelector('.member-accept')
    const reject = request.querySelector('.member-reject')

    if (!accept || !reject) continue

    // member id is all but the first character
    const member_id = accept.id.slice(1)

    accept.addEventListener('click', () => {
      resolveMemberRequest(group, member_id, request, 'accept')
    })

    reject.addEventListener('click', () => {
      resolveMemberRequest(group, member_id, request, 'reject')
    })
  }
}

toggleSections()
addLeaveGroupEvent()
addJoinGroupEvent()
addCancelJoinGroupEvent()
addResolveMemberRequestEvents()
// addRemoveMemberEvents -> when loading elements (infinite scrolling)
