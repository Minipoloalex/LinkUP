// Path: public/js/group/group.js
const Swal = window.swal

function toggleSections () {
  const posts = document.getElementById('posts')
  const members = document.getElementById('members')
  const requests = document.getElementById('requests')

  if (!posts || !members || !requests) return

  const posts_section = document.getElementById('posts-section')
  const members_section = document.getElementById('members-section')
  const requests_section = document.getElementById('requests-section')

  posts.addEventListener('click', () => {
    posts_section.classList.remove('hidden')
    members_section.classList.add('hidden')
    requests_section.classList.add('hidden')
  })

  members.addEventListener('click', () => {
    members_section.classList.remove('hidden')
    posts_section.classList.add('hidden')
    requests_section.classList.add('hidden')
  })

  requests.addEventListener('click', () => {
    requests_section.classList.remove('hidden')
    posts_section.classList.add('hidden')
    members_section.classList.add('hidden')
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

function addRemoveMemberEvents () {
  const group = document.getElementById('group-id').value
  const members = document.querySelectorAll('#members-section > div')
  if (!members) return

  for (const member of members) {
    const name = member.querySelector('h1').textContent
    const button = member.querySelector('.member-remove')

    if (!button) continue

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
          removeMember(group, member_id, member)
        }
      })
    })
  }
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
  const group = document.getElementById('group-id').value
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

        const text = new_button.querySelector('div')
        text.textContent = 'Pending'

        button.parentNode.replaceChild(new_button, button)
        addCancelJoinGroupEvent()
      }
    })
    .catch(error => console.error(error))
}

function addJoinGroupEvent () {
  const group = document.getElementById('group-id').value
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

        const text = new_button.querySelector('div')
        text.textContent = 'Join group'

        button.parentNode.replaceChild(new_button, button)
        addJoinGroupEvent()
      }
    })
    .catch(error => console.error(error))
}

function addCancelJoinGroupEvent () {
  const group = document.getElementById('group-id').value
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
  const group = document.getElementById('group-id').value
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
      console.log(member_id)
    })

    reject.addEventListener('click', () => {
      resolveMemberRequest(group, member_id, request, 'reject')
      console.log(member_id)
    })
  }
}

toggleSections()
addRemoveMemberEvents()
addLeaveGroupEvent()
addJoinGroupEvent()
addCancelJoinGroupEvent()
addResolveMemberRequestEvents()
