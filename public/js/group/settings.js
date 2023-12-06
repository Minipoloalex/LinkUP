// Path: public/js/group/group.js
const Swal = window.swal

function groupPhotoHover() {
  const groupPhoto = document.getElementById('change-group-photo')
  if (!groupPhoto) return

  const shadowHover = document.getElementById('group-photo-hover')

  groupPhoto.addEventListener('mouseover', () => {
    shadowHover.classList.remove('hidden')
  })

  groupPhoto.addEventListener('mouseout', () => {
    shadowHover.classList.add('hidden')
  })

  const groupPhotoInput = document.getElementById('group-photo-input')
  const groupImg = document.getElementById('group-photo-img')

  // groupPhotoInput.addEventListener('change', () => {
  //   const file = groupPhotoInput.files[0]
  //   const reader = new FileReader()

  //   reader.onload = () => {
  //     groupImg.src = reader.result
  //   }

  //   if (file) {
  //     reader.readAsDataURL(file)
  //   }
  // })
}

function deleteGroup(groupId) {
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

function addDeleteGroupEvent() {
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

groupPhotoHover()
addDeleteGroupEvent()
