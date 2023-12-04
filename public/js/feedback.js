import { show, hide } from "./general_helpers.js";

const feedbackMessage = document.querySelector('#feedback-message');
if (feedbackMessage) {
    const closeFeedback = document.querySelector('#dismiss-feedback');
    closeFeedback.addEventListener('click', dismissFeedback);
}
function dismissFeedback() {
    hide(feedbackMessage);
}
export function showFeedback(message) {
    show(feedbackMessage);
    feedbackMessage.querySelector('#feedback-text').textContent = message;
}
