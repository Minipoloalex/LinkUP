function hideSuccessMessage () {
  const successMessage = document.querySelector('.success')
  if (successMessage) {
    setTimeout(() => {
      successMessage.style.display = 'none'
    }, 5000)
  }
}

function hideErrorMessage () {
  const errorMessage = document.querySelector('.error')
  if (errorMessage) {
    setTimeout(() => {
      errorMessage.style.display = 'none'
    }, 5000)
  }
}

hideSuccessMessage()
hideErrorMessage()

const pwdFeedback = document.getElementById('pwd-feedback')

if (pwdFeedback) {
  const button = document.getElementById('login-button')
  const password = document.getElementById('password')

  button.addEventListener('click', event => {
    if (password.value.length < 8) {
      event.preventDefault()
      pwdFeedback.classList.remove('invisible')

      setTimeout(() => {
        pwdFeedback.classList.add('invisible')
      }, 3000)
    }
  })
}
