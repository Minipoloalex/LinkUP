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

    const deleteFollowerButton = network.querySelectorAll('.delete-follower');
    deleteFollowerButton.forEach(but => but.addEventListener('click', deleteFollower));
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
    show(followers);
    hide(following);
    getFollowersButton().classList.add('active');
    getFollowingButton().classList.remove('active');
}
function showFollowing(event) {
    event.preventDefault();
    const followers = getFollowersList(network);
    const following = getFollowingList(network);
    hide(followers);
    show(following);
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
function incrementCount(element) {
    element.textContent = parseInt(element.textContent) + 1;
}
