// Path: public/js/group/group.js
const Swal = window.swal

function groupPhotoHover () {
  const groupPhoto = document.getElementById('change-group-photo')
  if (!groupPhoto) return

  const shadowHover = document.getElementById('group-photo-hover')

  groupPhoto.addEventListener('mouseover', () => {
    shadowHover.classList.remove('hidden')
  })

  groupPhoto.addEventListener('mouseout', () => {
    shadowHover.classList.add('hidden')
  })
}

function deleteGroup (groupId) {
  const url = `/group/${groupId}`

  fetch(url, {
    method: 'DELETE',
    headers: {
      'Content-Type': 'application/json',
      'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
    }
  })
    .then(response => {
      if (response.ok) {
        window.location.href = '/home'
      }
    })
    .catch(error => console.error(error))
}

function addChangeOwnerEvent () {
  const button = document.getElementById('change-owner-btn')
  const form = document.getElementById('change-owner-form')
  if (!button) return

  button.addEventListener('click', event => {
    event.preventDefault()

    Swal.fire({
      title: '<h1 class="text-dark-active">Change owner?</h1>',
      html: '<p class="text-white">Are you sure you want to change the owner of this group?</p>',
      icon: 'warning',
      iconColor: '#A58AD6',
      showCancelButton: true,
      confirmButtonColor: '#EF4444',
      confirmButtonText: 'Yes, change.',
      background: '#333333',
    }).then(result => {
      if (result.isConfirmed) {
        Swal.fire({
          title: '<h1 class="text-dark-active">Enter your password</h1>',
          input: 'password',
          inputAttributes: {
            autocapitalize: 'off'
          },
          showCancelButton: true,
          confirmButtonText: 'Change',
          confirmButtonColor: '#EF4444',
          showLoaderOnConfirm: true,
          background: '#333333',
          preConfirm: password => {
            const url = '/group/verify-password'

            return fetch(url, {
              method: 'POST',
              headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector(
                  'meta[name="csrf-token"]'
                ).content
              },
              body: JSON.stringify({ password })
            })
              .then(response => {
                if (!response.ok) {
                  throw new Error()
                }
                return true
              })
              .catch(() => {
                Swal.showValidationMessage('The password is incorrect.')
              })
          },
          allowOutsideClick: () => !Swal.isLoading()
        }).then(result => {
          if (result.isConfirmed) {
            form.submit()
          }
        })
      }
    })
  })
}

function addDeleteGroupEvent () {
  const button = document.getElementById('delete-group')
  if (!button) return

  button.addEventListener('click', () => {
    const groupId = document.getElementById('group-id').value

    Swal.fire({
      title: '<h1 class="text-dark-active">Delete group?</h1>',
      html: '<p class="text-white">Are you sure you want to delete this group?</p>',
      icon: 'warning',
      iconColor: '#A58AD6',
      showCancelButton: true,
      confirmButtonColor: '#EF4444',
      cancelButtonColor: '#aaa',
      confirmButtonText: 'Yes, delete.',
      background: '#333333',
    }).then(result => {
      if (result.isConfirmed) {
        Swal.fire({
          title: '<h1 class="text-dark-active">Enter your password</h1>',
          input: 'password',
          inputAttributes: {
            autocapitalize: 'off'
          },
          showCancelButton: true,
          confirmButtonText: 'Delete',
          confirmButtonColor: '#EF4444',
          showLoaderOnConfirm: true,
          background: '#333333',
          preConfirm: password => {
            const url = '/group/verify-password'

            return fetch(url, {
              method: 'POST',
              headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector(
                  'meta[name="csrf-token"]'
                ).content
              },
              body: JSON.stringify({ password })
            })
              .then(response => {
                if (!response.ok) {
                  throw new Error()
                }
                return true
              })
              .catch(() => {
                Swal.showValidationMessage('The password is incorrect.')
              })
          },
          allowOutsideClick: () => !Swal.isLoading()
        }).then(result => {
          if (result.isConfirmed) {
            deleteGroup(groupId)
          }
        })
      }
    })
  })
}

document.addEventListener('DOMContentLoaded', function () {
  const inviteForm = document.getElementById('invite-user');
  inviteForm.addEventListener('submit', async (event) => {
      event.preventDefault();
      const groupId = document.getElementById('group-id').value;
      const selectedUserId = document.getElementById('new-member').value;
      const url = `/group/${groupId}/invite/${selectedUserId}`;
   
      let response
      try {
        response = await fetch(url, {
          method: 'POST',
          headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector(
              'meta[name="csrf-token"]'
            ).content
          },
          body: JSON.stringify({ new_member: selectedUserId })
        })
      } catch (error) {
        console.error('Error sending invitation:', error.message)
      }
      try {
        if (response.status >= 400 && response.status < 500) {
          const data = await response.json()
          if (data.error) {
            await Swal.fire({
              title: '<h1 class="text-dark-active">Error sending invitation</h1>',
              html: `<p class="text-white">${data.error}</p>`,
              icon: 'error',
              iconColor: '#A58AD6',
              confirmButtonText: 'Ok',
              confirmButtonColor: '#A58AD6',
              background: '#333333',
            })
          }
        }
        else if (response.ok) {
          await Swal.fire({
            title: '<h1 class="text-dark-active">Invitation sent!</h1>',
            html: '<p class="text-white">The invitation has been sent.</p>',
            icon: 'success',
            iconColor: '#A58AD6',
            confirmButtonText: 'Ok',
            confirmButtonColor: '#A58AD6',
            background: '#333333',
          })
          }
        }
      catch (error) {
        console.error('Error sending invitation:', error.message)
      }
    }
  )
})


groupPhotoHover()
addDeleteGroupEvent()
addChangeOwnerEvent()
