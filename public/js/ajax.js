function encodeForAjax(data) {
  if (data == null) return null;
  return Object.keys(data).map(function (k) {
    return encodeURIComponent(k) + '=' + encodeURIComponent(data[k])
  }).join('&');
}

function getCsrfToken() {
  return document.querySelector('meta[name="csrf-token"]').content;
}

async function sendAjaxRequest(method, url, data, handler) {
  return await fetch(url, {
    method: method,
    headers: {
      'X-CSRF-TOKEN': getCsrfToken(),
      'Content-Type': 'application/x-www-form-urlencoded'
    },
    body: encodeForAjax(data)
  });
}
