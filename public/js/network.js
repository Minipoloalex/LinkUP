// followers/following

const network = document.querySelector('#network');
const followingButton = network.querySelector('#following-button');
const followersButton = network.querySelector('#followers-button');
if (network && followingButton && followersButton) {
    followersButton.addEventListener('click', showFollowers);
    followingButton.addEventListener('click', showFollowing);
}

const deleteFollowingButtons = network.querySelectorAll('.delete-following');
deleteFollowingButtons.forEach(but => but.addEventListener('click', deleteFollowing));

const deleteFollowerButton = network.querySelectorAll('.delete-follower') ?? [];
deleteFollowerButton.forEach(but => but.addEventListener('click', deleteFollower));
    
const addFollowButtons = document.querySelectorAll('.add-follow');  // on profile page
addFollowButtons.forEach(but => but.addEventListener('click', addFollow));

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
        }
    }
}
async function deleteFollower(event) {
    deleteFollowGeneral('follower', event);
}
async function deleteFollowing(event) {
    deleteFollowGeneral('following', event);
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
