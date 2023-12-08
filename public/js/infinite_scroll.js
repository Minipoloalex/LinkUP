import { encodeForAjax } from './ajax.js';
import { parseHTML } from './general_helpers.js';

async function fetchAndLoad(container, url) {
  const page = container.dataset.page;
  console.log(encodeForAjax({page: page}));

  const response = await fetch(url + `?page=${page}`, {
    method: 'GET',
    headers: {
      'Content-Type': 'application/x-www-form-urlencoded'
    },
  });
  const data = await response.json();
  console.log(data);
  for (const postHTML of data.resultsHTML) {
    const postElement = parseHTML(postHTML);
    container.insertBefore(postElement, container.lastElementChild);
  }
  container.dataset.page = parseInt(page) + 1;
}
async function createFetcher(container, url) {
  await fetchAndLoad(container, url);   // initial loading

  const observer = new IntersectionObserver(async (entries) => {
    if (entries[0].isIntersecting) {
      await fetchAndLoad(container, url);
    }
  });
  observer.observe(fetcher);
}

export async function infiniteScroll(container, url) {
  createFetcher(container, url);
}
