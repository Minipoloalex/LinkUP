// followers/following

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
    getFollowRequestsButton().addEventListener('click', showFollowRequests);

    const deleteFollowingButtons = network.querySelectorAll('.delete-following');
    deleteFollowingButtons.forEach(but => but.addEventListener('click', deleteFollowing));

    const deleteFollowerButton = network.querySelectorAll('.delete-follower');
    deleteFollowerButton.forEach(but => but.addEventListener('click', deleteFollower));

    const cancelFollowRequestSentButtons = network.querySelectorAll('.cancel-follow-request');
    cancelFollowRequestSentButtons.forEach(but => but.addEventListener('click', cancelFollowRequestSent));

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
function showFollowers(event) {
    event.preventDefault();
    show(getFollowersList(network));
    hide(getFollowingList(network));
    hide(getFollowRequestsList(network));
    getFollowersButton().classList.add('active');
    getFollowingButton().classList.remove('active');
    getFollowRequestsButton().classList.remove('active');
}
function showFollowing(event) {
    event.preventDefault();
    hide(getFollowersList(network));
    show(getFollowingList(network));
    hide(getFollowRequestsList(network));
    getFollowersButton().classList.remove('active');
    getFollowingButton().classList.add('active');
    getFollowRequestsButton().classList.remove('active');
}
function showFollowRequests(event) {
    event.preventDefault();
    hide(getFollowersList(network));
    hide(getFollowingList(network));
    show(getFollowRequestsList(network));
    getFollowersButton().classList.remove('active');
    getFollowingButton().classList.remove('active');
    getFollowRequestsButton().classList.add('active');
}

// type = 'follower' or 'following' or 'deny-follow-request' or 'accept-follow-request' or 'cancel-follow-request'
async function generalFollowHandler(event, ajax, confirmMessage, action) {
    event.preventDefault();
    const button = event.currentTarget;
    const userId = button.dataset.id;
    const username = button.dataset.username;

    if (confirm(confirmMessage(username))) {
        const data = await ajax(userId, username);
        if (data != null) {
            const userArticle = button.closest('article');
            userArticle.remove();
            action();
        }
    }
}
async function deleteFollower(event) {
    return await generalFollowHandler(event,
        (userId, username) => sendAjaxRequest('DELETE', `/follow/follower/${userId}`, null),
        (username) => `Are you sure you want to delete ${username} from your follower list?`,
        () => decrementCount(getFollowersButton())
    );
}
async function deleteFollowing(event) {
    return await generalFollowHandler(event,
        (userId, username) => sendAjaxRequest('DELETE', `/follow/following/${userId}`, null),
        (username) => `Are you sure you want to delete ${username} from your following list?`,
        () => decrementCount(getFollowingButton())
    );
}
async function cancelFollowRequestSent(event) {
    return await generalFollowHandler(event,
        (userId, username) => sendAjaxRequest('DELETE', `/follow/request/cancel/${userId}`, null),
        (username) => `Are you sure you want to cancel your follow request to ${username}?`,
        () => decrementCount(getFollowRequestsButton())
    );
}
async function denyFollowRequestReceived(event) {
    return await generalFollowHandler(event,
        (userId, username) => sendAjaxRequest('DELETE', `/follow/request/deny/${userId}`, null),
        (username) => `Are you sure you want to delete ${username}'s follow request?`,
        () => decrementCount(getFollowRequestsButton())
    );
}
async function acceptFollowRequest(event) {
    return await generalFollowHandler(event,
        (userId, username) => sendAjaxRequest('PATCH', `/follow/request/accept/${userId}`, null),
        (username) => `Are you sure you want to accept ${username}'s follow request?`,
        () => {
            decrementCount(getFollowRequestsButton());
            incrementCount(getFollowingButton());
            // const followersList = getFollowersList();
            // const user_follower = buildFollower();
            // followersList.appendChild(user_follower);
        });
}
function decrementCount(element) {
    element.textContent = parseInt(element.textContent) - 1;
}
function incrementCount(element) {
    element.textContent = parseInt(element.textContent) + 1;
}
function buildUser(user) {
    const userArticle = document.createElement('article');
    userArticle.classList.add('user');
    /*
    <article class="border-2 p-5 flex justify-between">
        <a href="{{ url("/profile/" . $user->username) }}" class="user-follow flex gap-4 items-center">
            <img class="w-8 h-8" src="{{ $user->getProfilePicture() }}" alt="Profile Picture">
            <div id="user-info" class="flex flex-col">
                <p class="font-bold">{{ $user->name }}</p>
                <p class="text-gray-600">{{ $user->username }}</p>
            </div>
        </a>
        @auth
            @if ($editable) 
                <div class="flex flex-row">
                    @foreach($buttons as $button)
                        <button data-id="{{ $user->id }}" data-username="{{ $user->username }}" class="{{ $button['class'] }} justify-end p-2">{{ $button['text'] }}</button>
                    @endforeach
                </div>
            @endif
        @endauth
    </article>
    */

    // const userFollow = document.createElement('a');
    // userFollow.classList.add('user-follow');
    // userFollow.classList.add('flex');
    // userFollow.classList.add('gap-4');
    // userFollow.classList.add('items-center');
    // userFollow.href = `/profile/${user.username}`;
    
    return userArticle;
}
