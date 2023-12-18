import { showFeedback } from "./feedback.js";

export function encodeForAjax(data) {
  if (data == null) return null;
  return Object.keys(data).map(function (k) {
    return encodeURIComponent(k) + '=' + encodeURIComponent(data[k])
  }).join('&');
}

export function getCsrfToken() {
  return document.querySelector('meta[name="csrf-token"]').content;
}

export async function handleFeedbackToResponse(response) {
  if (response.ok) {
    const data = await response.json();
    if (data.error) {
      Swal.fire('Error', data.error, 'error');
    }
    else {
      if (data.success) {
        showFeedback(data.success);
      }
      return data ?? [];
    }
  }
  else {
    if (response.status < 500) {
      response.json().then(data => {
        if (data.error) {
          Swal.fire('Error', data.error, 'error');
        }
      }).catch(error => {
        console.error(error);
      });
    }
    else showFeedback(response.statusText);
  }
  return null;
}

export async function sendAjaxRequest(method, url, data) {
  const response = await fetch(url, {
    method: method,
    headers: {
      'X-CSRF-TOKEN': getCsrfToken(),
      'Content-Type': 'application/x-www-form-urlencoded',
      'Accept': 'application/json'
    },
    body: encodeForAjax(data)
  });
  return handleFeedbackToResponse(response);
}
