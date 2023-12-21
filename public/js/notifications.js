import { pushNotification } from './toast.js'

const pusherAppKey = 'da80c91c23404a2f4cfd'
const pusherCluster = 'eu'

function getUserId () {
  const element = document.querySelector('meta[name="user-id"]')
  return element ? element.getAttribute('content') : null
}

async function getImageUrl (id) {
  const scheme = window.location.protocol + '//'
  const host = window.location.host + '/'
  
  const url = `/api/users/picture/${id}`

  const path = fetch(url, {
    method: 'GET',
    headers: {
      'Content-Type': 'application/json'
    }
  })
    .then(response => {
      console.log(response)
      if (response.ok) {
        return response.json()
      }
      throw new Error('Network response was not ok.')
    })
    .then(data => {
      return data.path
    })
    .catch(error => {
      console.error(`Fetch error: ${error.message}`)
    })

  return path
}

async function getUser (id) {
  const scheme = window.location.protocol + '//'
  const host = window.location.host + '/'
  const url = `/api/users/${id}`

  const user = fetch(url, {
    method: 'GET',
    headers: {
      'Content-Type': 'application/json'
    }
  })
    .then(response => {
      if (response.ok) {
        return response.json()
      }
      throw new Error('Network response was not ok.')
    })
    .then(data => {
      return data
    })
    .catch(error => {
      console.error(`Fetch error: ${error.message}`)
    })

  return user
}

const userId = getUserId()

if (userId) {
  const pusher = new Pusher(pusherAppKey, {
    cluster: pusherCluster,
    encrypted: true,
    authEndpoint: '/broadcasting/auth'
  })

  const channel = pusher.subscribe(`private-user.${userId}`)

  channel.bind('notification-comment', async notification => {
    const data = notification.commentNotification

    const link = `/post/${data.comment.id}`
    const user = await getUser(data.comment.id_created_by)
    const image = await getImageUrl(user.id)
    const username = user.username
    const message = 'commented on your post.'

    pushNotification({ link, image, username, message })
  })

  channel.bind('notification-followrequest', async notification => {
    const data = notification.followRequest
    const user = await getUser(data.id_user_from)

    const link = `/profile/${user.username}`
    const image = await getImageUrl(user.id)
    const username = user.username
    const message = 'sent you a follow request.'

    pushNotification({ link, image, username, message })
  })

  channel.bind('notification-like', async notification => {
    const data = notification.likeNotification

    const link = `/post/${data.post.id}`
    const user = await getUser(data.id_user)
    const image = await getImageUrl(user.id)
    const username = user.username
    const message = 'liked your post.'

    pushNotification({ link, image, username, message })
  })

  channel.bind('notification-group', async notification => {
    const groupNotification = notification.groupNotification
    const user = notification.userThatSent
    const groupName = notification.groupName


    const groupNotificationType = groupNotification.type    

    const link = `/group/${groupNotification.id_group}`
    const image = await getImageUrl(user.id)
    const username = user.username
    let message = ''
    if (groupNotificationType === 'Invitation') {
      message = 'invited you to join the group ' + groupName
    }
    else {
      message = 'wants to join the group ' + groupName
    }
    pushNotification({ link, image, username, message })
  })
}
