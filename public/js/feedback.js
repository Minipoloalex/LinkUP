const feedbackMessage = document.querySelector('#feedback-message');
if (feedbackMessage) {
    const closeFeedback = document.querySelector('#dismiss-feedback');
    closeFeedback.addEventListener('click', dismissFeedback);
}
function dismissFeedback() {
    feedbackMessage.classList.add('hidden');
}
function showFeedback(message) {
    feedbackMessage.classList.remove('hidden');
    feedbackMessage.querySelector('#feedback-text').textContent = message;
}
