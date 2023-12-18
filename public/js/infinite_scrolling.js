import { encodeForAjax } from './ajax.js'

async function fetchAndLoad (container, url, data, action) {
  const page = container.dataset.page
  data.page = page
  console.log(data)
  const response = await fetch(url + `?${encodeForAjax(data)}`, {
    method: 'GET',
    headers: {
      'Content-Type': 'application/x-www-form-urlencoded'
    }
  })
  const result = await response.json()
  console.log(result)
  action(result)

  container.dataset.page = parseInt(page) + 1
}

let observers = []
async function createFetcher (
  container,
  testIntersectionElement,
  url,
  firstAction,
  action,
  data
) {
  await fetchAndLoad(container, url, data, firstAction) // initial loading

  const observer = new IntersectionObserver(async entries => {
    if (entries[0].isIntersecting) {
      await fetchAndLoad(container, url, data, action)
    }
  })
  observer.observe(testIntersectionElement)
  observers.push(observer)
  return observer
}

export async function infiniteScroll (
  container,
  testIntersectionElement,
  url,
  firstAction,
  action,
  resetPage = true,
  destroyPreviousFetcher = true,
  data = {}
) {
  if (resetPage) {
    container.dataset.page = 0
  }
  if (destroyPreviousFetcher) {
    observers.forEach(async observer => {
      await observer.disconnect()
    })
  }
  return await createFetcher(
    container,
    testIntersectionElement,
    url,
    firstAction,
    action,
    data
  )
}

export async function destroyFetcher (observer) {
  if (observer) {
    await observer.disconnect()
  }
}
