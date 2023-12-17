import { sendAjaxRequest } from './ajax.js'
import { hide, show } from './general_helpers.js'
import { swalConfirmDelete, parseHTML } from './general_helpers.js'
import { getUrlParameter, setUrlParameters } from './general_helpers.js'

const network = document.querySelector('#network')
function getFollowersButton () {
  return network.querySelector('#followers-button')
}
function getFollowingButton () {
  return network.querySelector('#following-button')
}
function getFollowRequestsButton () {
  return network.querySelector('#follow-requests-button')
}
function getGroupsButton () {
  return network.querySelector('#groups-button')
}

if (network) {
  getFollowersButton().addEventListener('click', showFollowers)
  getFollowingButton().addEventListener('click', showFollowing)
  const followRequestsButton = getFollowRequestsButton()
  if (followRequestsButton)
    followRequestsButton.addEventListener('click', showFollowRequests)
  getGroupsButton().addEventListener('click', showGroups)

  const deleteFollowingButtons = network.querySelectorAll('.delete-following')
  deleteFollowingButtons.forEach(but =>
    but.addEventListener('click', deleteFollowing)
  )

  const deleteFollowerButton = network.querySelectorAll('.delete-follower')
  deleteFollowerButton.forEach(but =>
    but.addEventListener('click', deleteFollower)
  )

  const denyFollowRequestReceivedButtons = network.querySelectorAll(
    '.deny-follow-request'
  )
  denyFollowRequestReceivedButtons.forEach(but =>
    but.addEventListener('click', denyFollowRequestReceived)
  )

  const acceptFollowRequestButtons = network.querySelectorAll(
    '.accept-follow-request'
  )
  acceptFollowRequestButtons.forEach(but =>
    but.addEventListener('click', acceptFollowRequest)
  )
  initNetworkPage()
}

function getFollowersList (container) {
  return container.querySelector('#followers-list')
}
function getFollowingList (container) {
  return container.querySelector('#following-list')
}
function getFollowRequestsList (container) {
  return container.querySelector('#follow-requests-list')
}
function getGroupsList () {
  return network.querySelector('#groups-list')
}
function addActiveClass (element) {
  if (element) element.classList.add('active')
}
function removeActiveClass (element) {
  if (element) element.classList.remove('active')
}
function showFollowers (event) {
  event.preventDefault()
  addActiveClass(getFollowersButton())
  removeActiveClass(getFollowingButton())
  removeActiveClass(getFollowRequestsButton())
  removeActiveClass(getGroupsButton())
  show(getFollowersList(network))
  hide(getFollowingList(network))
  hide(getFollowRequestsList(network))
  hide(getGroupsList())
  setNetworkSectionURL('followers')
}
function showFollowing (event) {
  event.preventDefault()
  removeActiveClass(getFollowersButton())
  addActiveClass(getFollowingButton())
  removeActiveClass(getFollowRequestsButton())
  removeActiveClass(getGroupsButton())
  hide(getFollowersList(network))
  show(getFollowingList(network))
  hide(getFollowRequestsList(network))
  hide(getGroupsList())
  setNetworkSectionURL('following')
}
function showFollowRequests (event) {
  event.preventDefault()
  removeActiveClass(getFollowersButton())
  removeActiveClass(getFollowingButton())
  addActiveClass(getFollowRequestsButton())
  removeActiveClass(getGroupsButton())
  hide(getFollowersList(network))
  hide(getFollowingList(network))
  show(getFollowRequestsList(network))
  hide(getGroupsList())
  setNetworkSectionURL('follow-requests')
}
function showGroups (event) {
  event.preventDefault()
  removeActiveClass(getFollowersButton())
  removeActiveClass(getFollowingButton())
  removeActiveClass(getFollowRequestsButton())
  addActiveClass(getGroupsButton())
  hide(getFollowersList(network))
  hide(getFollowingList(network))
  hide(getFollowRequestsList(network))
  show(getGroupsList())
  setNetworkSectionURL('groups')
}

// 'remove-follower' or 'remove-following' or 'deny-follow-request' or 'accept-follow-request'
async function generalFollowHandler (
  event,
  ajax,
  titleConfirmMessage,
  confirmMessage,
  confirmButtonText,
  action,
  actionResultMessageTitle,
  actionResultMessage
) {
  event.preventDefault()
  const button = event.currentTarget
  const userId = button.dataset.id
  const username = button.dataset.username

  swalConfirmDelete(
    titleConfirmMessage,
    confirmMessage(username),
    async () => {
      const data = await ajax(userId)
      if (data != null) {
        const userArticle = button.closest('article')
        userArticle.remove()
        action(data)
        Swal.fire(
          actionResultMessageTitle,
          actionResultMessage(username),
          'success'
        )
      }
    },
    null,
    confirmButtonText
  )
}
async function deleteFollower (event) {
  return await generalFollowHandler(
    event,
    userId => sendAjaxRequest('DELETE', `/follow/follower/${userId}`, null),
    'Remove follower?',
    username =>
      `Are you sure you want to remove ${username} from your follower list?`,
    'Yes, delete.',
    data => {
      decrementCount(getFollowersButton())
      handleEmpty(getFollowersList(network), 'You have no followers')
    },
    'Removed!',
    username => `${username} has been removed from your followers list.`
  )
}
async function deleteFollowing (event) {
  return await generalFollowHandler(
    event,
    userId => sendAjaxRequest('DELETE', `/follow/following/${userId}`, null),
    'Stop following?',
    username =>
      `Are you sure you want to delete ${username} from your following list?`,
    'Yes, unfollow.',
    data => {
      decrementCount(getFollowingButton())
      handleEmpty(getFollowingList(network), 'You are not following anyone')
    },
    'Unfollowed!',
    username => `You unfollowed ${username}.`
  )
}

async function denyFollowRequestReceived (event) {
  return await generalFollowHandler(
    event,
    userId => sendAjaxRequest('DELETE', `/follow/request/deny/${userId}`, null),
    'Deny follow request?',
    username => `Are you sure you want to deny ${username}'s follow request?`,
    'Yes, deny.',
    data => {
      decrementCount(getFollowRequestsButton())
      handleEmpty(
        getFollowRequestsList(network),
        'You have received no follow requests'
      )
    },
    'Denied!',
    username => `You denied ${username}'s follow request.`
  )
}
async function acceptFollowRequest (event) {
  return await generalFollowHandler(
    event,
    userId =>
      sendAjaxRequest('PATCH', `/follow/request/accept/${userId}`, null),
    'Accept follow request?',
    username => `Are you sure you want to accept ${username}'s follow request?`,
    'Yes, accept.',
    data => {
      decrementCount(getFollowRequestsButton())
      incrementCount(getFollowersButton())
      handleRemoveEmpty(getFollowersList(network))

      const userHTML = parseHTML(data.userHTML)

      getFollowersList(network).appendChild(userHTML) // append to the followers list
      const deleteFollowerButton = userHTML.querySelector('.delete-follower')
      deleteFollowerButton.addEventListener('click', deleteFollower)

      handleEmpty(
        getFollowRequestsList(network),
        'You have received no follow requests'
      )
    },
    'Accepted!',
    username => `You accepted ${username}'s follow request.`
  )
}
export function decrementCount (element) {
  const num = parseInt(element.textContent) - 1
  element.textContent = num
}
export function incrementCount (element) {
  const num = parseInt(element.textContent) + 1
  element.textContent = num
}

function handleEmpty (container, message) {
  if (container.children.length == 0) {
    const emptyList = document.createElement('p')
    emptyList.classList.add('empty-list')
    emptyList.textContent = message

    container.appendChild(emptyList)
  }
}
function handleRemoveEmpty (container) {
  if (container.firstElementChild.classList.contains('empty-list')) {
    container.firstElementChild.remove()
  }
}

function getUrlParameterName() {
  return 'section'
}

function initNetworkPage () {
  const section = getUrlParameter(getUrlParameterName())
  if (section == null) {
    return
  }
  switch (section) {
    case 'followers':
      showFollowers(new Event('click'))
      break
    case 'following':
      showFollowing(new Event('click'))
      break
    case 'follow-requests':
      showFollowRequests(new Event('click'))
      break
    case 'groups':
      showGroups(new Event('click'))
      break
  }
}
function setNetworkSectionURL(sectionName) {
  const param = getUrlParameterName()
  setUrlParameters({[param]: sectionName})
}
