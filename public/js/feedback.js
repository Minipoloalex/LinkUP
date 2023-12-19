import { show, hide } from './general_helpers.js'

const feedbackMessage = document.querySelector('#feedback-message')
const active = 'feedback-active'

if (feedbackMessage) {
  const closeFeedback = document.querySelector('#dismiss-feedback')
  closeFeedback.addEventListener('click', dismissFeedback)
}

function dismissFeedback () {
  feedbackMessage.classList.remove(active)
}

export function showFeedback (message) {
  feedbackMessage.classList.add(active)
  if (feedbackMessage) {
    feedbackMessage.querySelector('#feedback-text').textContent = message
  }

  setTimeout(() => {
    feedbackMessage.classList.remove(active)
  }, 3000)
}

if (feedbackMessage) {
  setTimeout(() => {
    feedbackMessage.classList.remove(active)
  }, 3000)
}
