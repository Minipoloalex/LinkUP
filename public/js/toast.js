let timer
window.open = false

const toast = document.getElementById('toast')
const toastImage = document.getElementById('toast-image')
const toastUsername = document.getElementById('toast-username')
const toastMessage = document.getElementById('toast-message')

const openToast = () => {
  if (window.open) return
  window.open = true
  toast.classList.add('translate-y-20')

  clearTimeout(timer)

  timer = setTimeout(() => {
    closeToast()
    window.open = false
  }, 3000)
}

const closeToast = () => {
  window.open = false
  toast.classList.remove('translate-y-20')
}

toast.addEventListener('click', closeToast)

export function pushNotification (data) {
  const { link, image, username, message } = data
  toast.setAttribute('href', link)
  toastImage.src = image
  toastUsername.innerText = username
  toastMessage.innerText = message
  openToast()
}
