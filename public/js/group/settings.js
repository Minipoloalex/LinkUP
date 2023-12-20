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
      title: 'Change owner?',
      text: 'The new owner will have the same permissions as you.',
      icon: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#ff0000',
      cancelButtonColor: '#aaa',
      confirmButtonText: 'Yes, change.'
    }).then(result => {
      if (result.isConfirmed) {
        Swal.fire({
          title: 'Enter your password',
          input: 'password',
          inputAttributes: {
            autocapitalize: 'off'
          },
          showCancelButton: true,
          confirmButtonText: 'Change',
          confirmButtonColor: '#ff0000',
          showLoaderOnConfirm: true,
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
      title: 'Delete group?',
      text: "You won't be able to revert this! The group and all its posts will be deleted.",
      icon: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#ff0000',
      cancelButtonColor: '#aaa',
      confirmButtonText: 'Yes, delete.'
    }).then(result => {
      if (result.isConfirmed) {
        Swal.fire({
          title: 'Enter your password',
          input: 'password',
          inputAttributes: {
            autocapitalize: 'off'
          },
          showCancelButton: true,
          confirmButtonText: 'Delete',
          confirmButtonColor: '#ff0000',
          showLoaderOnConfirm: true,
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
  console.log('inviteForm:', inviteForm);
  inviteForm.addEventListener('submit', async (event) => {
      console.log('inviteForm submitted');
      event.preventDefault();
      const groupId = document.getElementById('group-id').value;
      console.log('groupId:', groupId);
      const selectedUserId = document.getElementById('new-member').value;
      console.log('selectedUserId:', selectedUserId);
      const url = `/group/${groupId}/invite/${selectedUserId}`;
   

      try {
        const response = await fetch(url, {
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
          console.error('Error sending invitation:', error.message);
      }
  });
});




groupPhotoHover()
addDeleteGroupEvent()
addChangeOwnerEvent()
