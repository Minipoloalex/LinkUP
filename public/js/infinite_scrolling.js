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

let observer = null
async function createFetcher (
  container,
  testIntersectionElement,
  url,
  firstAction,
  action,
  data
) {
  await fetchAndLoad(container, url, data, firstAction) // initial loading

  observer = new IntersectionObserver(async entries => {
    if (entries[0].isIntersecting) {
      await fetchAndLoad(container, url, data, action)
    }
  })
  observer.observe(testIntersectionElement)
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
    await destroyFetcher()
  }
  await createFetcher(
    container,
    testIntersectionElement,
    url,
    firstAction,
    action,
    data
  )
}

export async function destroyFetcher () {
  if (observer) {
    await observer.disconnect()
  }
}
