import { pushNotification } from './toast.js'

const pusherAppKey = 'da80c91c23404a2f4cfd'
const pusherCluster = 'eu'

function getUserId () {
  const element = document.querySelector('meta[name="user-id"]')
  return element ? element.getAttribute('content') : null
}

async function getImageUrl (id) {
  const url = `api/users/picture/${id}`

  const path = fetch(url, {
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
      return data.path
    })
    .catch(error => {
      console.error(`Fetch error: ${error.message}`)
    })

  return path
}

async function getUser (id) {
  const url = `api/users/${id}`

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

  console.log('getUser')
  console.log(user)
  return user
}

const userId = getUserId()

if (userId) {
  Pusher.logToConsole = true // TODO remove this for production

  const pusher = new Pusher(pusherAppKey, {
    cluster: pusherCluster,
    encrypted: true,
    authEndpoint: '/broadcasting/auth',
    debug: true // TODO remove this for production
  })

  const channel = pusher.subscribe(`private-user.${userId}`)

  channel.bind('notification-comment', function (data) {
    console.log('Received notification-comment')
    console.log(data)
  })

  channel.bind('notification-followrequest', function (data) {
    console.log('Received notification-followrequest')
    console.log(data)
  })

  channel.bind('notification-like', async notification => {
    const data = notification.likeNotification
    console.log(data)

    const link = `/post/${data.post.id}`
    const user = await getUser(data.id_user)
    const image = await getImageUrl(user.id)
    const username = user.username
    const message = 'liked your post.'

    pushNotification({ link, image, username, message })
  })

  channel.bind('notification-group', function (data) {
    console.log(data)
  })

  // channel.bind('notification-tag', function(data) {
  //     console.log(data);
  // });
}
