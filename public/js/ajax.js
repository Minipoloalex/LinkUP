function encodeForAjax(data) {
  if (data == null) return null;
  return Object.keys(data).map(function (k) {
    return encodeURIComponent(k) + '=' + encodeURIComponent(data[k])
  }).join('&');
}

function getCsrfToken() {
  return document.querySelector('meta[name="csrf-token"]').content;
}

async function handleFeedbackToResponse(response) {
  if (response.ok) {
    const data = await response.json();
    if (data.error) {
      showFeedback(data.error);
    }
    else {
      if (data.success) {
        showFeedback(data.success);
      }
      return data ?? [];
    }
  }
  else {
    showFeedback(response.statusText);
  }
  return null;
}

async function sendAjaxRequest(method, url, data) {
  const response = await fetch(url, {
    method: method,
    headers: {
      'X-CSRF-TOKEN': getCsrfToken(),
      'Content-Type': 'application/x-www-form-urlencoded'
    },
    body: encodeForAjax(data)
  });
  return handleFeedbackToResponse(response);
}
