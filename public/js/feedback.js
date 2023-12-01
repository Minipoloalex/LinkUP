const feedbackMessage = document.querySelector('#feedback-message');
if (feedbackMessage) {
    const closeFeedback = document.querySelector('#dismiss-feedback');
    closeFeedback.addEventListener('click', dismissFeedback);
}
function dismissFeedback() {
    hide(feedbackMessage);
}
function showFeedback(message) {
    show(feedbackMessage);
    feedbackMessage.querySelector('#feedback-text').textContent = message;
}
