import { sendAjaxRequest } from "./ajax.js";
import { hide, show } from "./general_helpers.js";

// JS for network page
const network = document.querySelector('#network');
function getFollowersButton() {
    return network.querySelector('#followers-button');
}
function getFollowingButton() {
    return network.querySelector('#following-button');
}
function getFollowRequestsButton() {
    return network.querySelector('#follow-requests-button');
}
if (network) {
    getFollowersButton().addEventListener('click', showFollowers);
    getFollowingButton().addEventListener('click', showFollowing);
    const followRequestsButton = getFollowRequestsButton();
    if (followRequestsButton) followRequestsButton.addEventListener('click', showFollowRequests);

    const deleteFollowingButtons = network.querySelectorAll('.delete-following');
    deleteFollowingButtons.forEach(but => but.addEventListener('click', deleteFollowing));

    const deleteFollowerButton = network.querySelectorAll('.delete-follower');
    deleteFollowerButton.forEach(but => but.addEventListener('click', deleteFollower));

    const denyFollowRequestReceivedButtons = network.querySelectorAll('.deny-follow-request');
    denyFollowRequestReceivedButtons.forEach(but => but.addEventListener('click', denyFollowRequestReceived));

    const acceptFollowRequestButtons = network.querySelectorAll('.accept-follow-request');
    acceptFollowRequestButtons.forEach(but => but.addEventListener('click', acceptFollowRequest));
}

function getFollowersList(container) {
    return container.querySelector('#followers-list');
}
function getFollowingList(container) {
    return container.querySelector('#following-list');
}
function getFollowRequestsList(container) {
    return container.querySelector('#follow-requests-list');
}
function addActiveClass(element) {
    if (element) element.classList.add('active');
}
function removeActiveClass(element) {
    if (element) element.classList.remove('active');
}
function showFollowers(event) {
    event.preventDefault();
    show(getFollowersList(network));
    hide(getFollowingList(network));
    hide(getFollowRequestsList(network));
    addActiveClass(getFollowersButton());
    removeActiveClass(getFollowingButton());
    removeActiveClass(getFollowRequestsButton());
}
function showFollowing(event) {
    event.preventDefault();
    hide(getFollowersList(network));
    show(getFollowingList(network));
    hide(getFollowRequestsList(network));
    removeActiveClass(getFollowersButton());
    addActiveClass(getFollowingButton());
    removeActiveClass(getFollowRequestsButton());
}
function showFollowRequests(event) {
    event.preventDefault();
    hide(getFollowersList(network));
    hide(getFollowingList(network));
    show(getFollowRequestsList(network));
    removeActiveClass(getFollowersButton());
    removeActiveClass(getFollowingButton());
    addActiveClass(getFollowRequestsButton());
}

// 'remove-follower' or 'remove-following' or 'deny-follow-request' or 'accept-follow-request' or 'cancel-follow-request'
async function generalFollowHandler(event, ajax, confirmMessage, action) {
    event.preventDefault();
    const button = event.currentTarget;
    const userId = button.dataset.id;
    const username = button.dataset.username;

    if (confirm(confirmMessage(username))) {
        const data = await ajax(userId);
        if (data != null) {
            const userArticle = button.closest('article');
            userArticle.remove();
            action(data);
        }
    }
}
async function deleteFollower(event) {
    return await generalFollowHandler(event,
        (userId) => sendAjaxRequest('DELETE', `/follow/follower/${userId}`, null),
        (username) => `Are you sure you want to delete ${username} from your follower list?`,
        (data) => {
            decrementCount(getFollowersButton());
            handleEmpty(getFollowersList(network), 'You have no followers');
        }
    );
}
async function deleteFollowing(event) {
    return await generalFollowHandler(event,
        (userId) => sendAjaxRequest('DELETE', `/follow/following/${userId}`, null),
        (username) => `Are you sure you want to delete ${username} from your following list?`,
        (data) => {
            decrementCount(getFollowingButton());
            handleEmpty(getFollowingList(network), 'You are not following anyone');
        }
    );
}

async function denyFollowRequestReceived(event) {
    return await generalFollowHandler(event,
        (userId) => sendAjaxRequest('DELETE', `/follow/request/deny/${userId}`, null),
        (username) => `Are you sure you want to delete ${username}'s follow request?`,
        (data) => {
            decrementCount(getFollowRequestsButton());
            handleEmpty(getFollowRequestsList(network), 'You have received no follow requests');
        }
    );
}
async function acceptFollowRequest(event) {
    return await generalFollowHandler(event,
        (userId) => sendAjaxRequest('PATCH', `/follow/request/accept/${userId}`, null),
        (username) => `Are you sure you want to accept ${username}'s follow request?`,
        (data) => {
            decrementCount(getFollowRequestsButton());
            incrementCount(getFollowersButton());
            handleRemoveEmpty(getFollowersList(network));

            const parser = new DOMParser();
            const doc = parser.parseFromString(data.userHTML, 'text/html'); // parse HTML received from server
            const userHTML = doc.body.firstElementChild;

            getFollowersList(network).appendChild(userHTML);    // append to the followers list

            const deleteFollowerButton = userHTML.querySelector('.delete-follower');
            deleteFollowerButton.addEventListener('click', deleteFollower);
            
            handleEmpty(getFollowRequestsList(network), 'You have received no follow requests');
        });
}
export function decrementCount(element) {
    element.textContent = parseInt(element.textContent) - 1;
}
export function incrementCount(element) {
    element.textContent = parseInt(element.textContent) + 1;
}

function handleEmpty(container, message) {
    if (container.children.length == 0) {
        const emptyList = document.createElement('p');
        emptyList.classList.add('empty-list');
        emptyList.textContent = message;

        container.appendChild(emptyList);
    }
}
function handleRemoveEmpty(container) {
    if (container.firstElementChild.classList.contains('empty-list')) {
        container.firstElementChild.remove();
    }
}
