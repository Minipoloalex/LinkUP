// followers/following

const network = document.querySelector('#network');
function getFollowersButton() {
    return network.querySelector('#followers-button');
}
function getFollowingButton() {
    return network.querySelector('#following-button');
}
if (network) {
    const followingButton = getFollowingButton();
    const followersButton = getFollowersButton();
    followersButton.addEventListener('click', showFollowers);
    followingButton.addEventListener('click', showFollowing);

    const deleteFollowingButtons = network.querySelectorAll('.delete-following');
    deleteFollowingButtons.forEach(but => but.addEventListener('click', deleteFollowing));

    const deleteFollowerButton = network.querySelectorAll('.delete-follower') ?? [];
    deleteFollowerButton.forEach(but => but.addEventListener('click', deleteFollower));
        
    const addFollowButtons = document.querySelectorAll('.add-follow');  // on profile page
    addFollowButtons.forEach(but => but.addEventListener('click', addFollow));
}

function getFollowersList(container) {
    return container.querySelector('#followers-list');
}
function getFollowingList(container) {
    return container.querySelector('#following-list');
}
function showFollowers(event) {
    event.preventDefault();
    const followers = getFollowersList(network);
    const following = getFollowingList(network);
    followers.classList.remove('hidden');
    following.classList.add('hidden');
    getFollowersButton().classList.add('active');
    getFollowingButton().classList.remove('active');
}
function showFollowing(event) {
    event.preventDefault();
    const followers = getFollowersList(network);
    const following = getFollowingList(network);
    followers.classList.add('hidden');
    following.classList.remove('hidden');
    getFollowersButton().classList.remove('active');
    getFollowingButton().classList.add('active');
}

// type = 'follower' or 'following'
async function deleteFollowGeneral(type, event) {    
    event.preventDefault();
    const button = event.currentTarget;
    const userId = button.dataset.id;
    const username = button.dataset.username;
    if (confirm(`Are you sure you want to delete ${username} from your ${type} list?`)) {
        const data = await sendAjaxRequest('DELETE', `/${type}/${userId}`, null);
        if (data != null) {
            const userArticle = button.closest('article');
            userArticle.remove();
            switch (type) {
                case 'follower':
                    decrementCount(getFollowersButton());
                    break;
                case 'following':
                    decrementCount(getFollowingButton());
                    break;
            }
        }
    }
}
async function deleteFollower(event) {
    deleteFollowGeneral('follower', event);
}
async function deleteFollowing(event) {
    deleteFollowGeneral('following', event);
}
function decrementCount(element) {
    element.textContent = parseInt(element.textContent) - 1;
}
// async function addFollow(event) {
//     event.preventDefault();
//     const button = event.currentTarget;
//     const userId = button.dataset.id;
//     const data = await sendAjaxRequest('POST', `/following/add/`, {userId: userId});
//     if (data != null) {
//         const followingNumber = document.querySelector('#following-number');
//         followingNumber.textContent = parseInt(followingNumber.textContent) + 1;
//     }
// }
async function requestToFollow(event) {
    event.preventDefault();
    const button = event.currentTarget;
    const userId = button.dataset.id;
    const data = await sendAjaxRequest('POST', `/following/add/`, {userId: userId});
    showRequestedToFollow(button);
    if (data != null) {
        const followingNumber = document.querySelector('#following-number');
        followingNumber.textContent = parseInt(followingNumber.textContent) + 1;
    }
    else {
        showFollowButton(button);
    }
}
function showFollowButton(followButton, requestedButton, unfollowButton) {
    show(followButton);
    hide(requestedButton);
    hide(unfollowButton);
}
function showRequestedToFollow(followButton, requestedButton, unfollowButton) {
    hide(followButton);
    show(requestedButton);
    hide(unfollowButton);
}
function showUnfollowButton(followButton, requestedButton, unfollowButton) {
    hide(followButton);
    hide(requestedButton);
    show(unfollowButton);
}
function hide(element) {
    button.classList.add('hidden');
}
function show(element) {
    button.classList.remove('hidden');
}