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

  const groupPhotoInput = document.getElementById('group-photo-input')
  const groupImg = document.getElementById('group-photo-img')

  groupPhotoInput.addEventListener('change', () => {
    const file = groupPhotoInput.files[0]
    const reader = new FileReader()

    reader.onload = () => {
      groupImg.src = reader.result
    }

    if (file) {
      reader.readAsDataURL(file)
    }
  })
}

groupPhotoHover()
