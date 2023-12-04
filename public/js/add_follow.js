import { sendAjaxRequest } from "./ajax.js";
import { show, hide } from "./general_helpers.js";
import { incrementCount, decrementCount } from "./network.js";

const requestToFollowButton = document.querySelector('#request-follow');
const sentFollowButton = document.querySelector('#sent-follow');
const unfollowButton = document.querySelector('#unfollow');
if (requestToFollowButton && sentFollowButton && unfollowButton) {
    requestToFollowButton.addEventListener('click', requestToFollow);
    sentFollowButton.addEventListener('click', cancelRequestFollow);
    unfollowButton.addEventListener('click', unfollow);
}
function getFollowingNumberElement() {
    return document.querySelector('#following-number');
}
async function requestToFollow(event) {
    event.preventDefault();
    const button = event.currentTarget;
    const userId = button.dataset.id;
    const data = await sendAjaxRequest('POST', '/follow', {id: userId});
    showRequestedToFollow();
    if (data != null) {
        if (data.accepted) {    // already accepted, show unfollow button
            const followingNumber = getFollowingNumberElement();
            incrementCount(followingNumber);
            showUnfollowButton();
        }
    }
    else {
        showFollowButton();
    }
}
async function unfollow(event) {
    event.preventDefault();
    const button = event.currentTarget;
    const userId = button.dataset.id;
    const data = await sendAjaxRequest('DELETE', `/follow/following/${userId}`, null);
    showFollowButton();
    if (data != null) {
        const followingNumber = getFollowingNumberElement();
        decrementCount(followingNumber);
    }
    else {
        showUnfollowButton();
    }
}
async function cancelRequestFollow(event) {
    event.preventDefault();
    const button = event.currentTarget;
    const userId = button.dataset.id;
    const data = await sendAjaxRequest('DELETE', `/follow/request/cancel/${userId}`, null);
    showFollowButton();
    if (data == null) {
        showRequestedToFollow();
    }
}

function showFollowButton() {
    show(requestToFollowButton);
    hide(sentFollowButton);
    hide(unfollowButton);
}
function showRequestedToFollow() {
    hide(requestToFollowButton);
    show(sentFollowButton);
    hide(unfollowButton);
}
function showUnfollowButton() {
    hide(requestToFollowButton);
    hide(sentFollowButton);
    show(unfollowButton);
}
