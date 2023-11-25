// followers/following

const network = document.querySelector('#network');
const followingButton = network.querySelector('#following-button');
const followersButton = network.querySelector('#followers-button');
if (network && followingButton && followersButton) {
    followersButton.addEventListener('click', showFollowers);
    followingButton.addEventListener('click', showFollowing);
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
    followersButton.classList.add('active');
    followingButton.classList.remove('active');
}
function showFollowing(event) {
    event.preventDefault();
    const followers = getFollowersList(network);
    const following = getFollowingList(network);
    followers.classList.add('hidden');
    following.classList.remove('hidden');
    followersButton.classList.remove('active');
    followingButton.classList.add('active');
}
