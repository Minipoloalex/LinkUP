export function hide(element) {
  if (element) {
    element.classList.add('hidden');
  }
}

export function show(element) {
  if (element) {
    element.classList.remove('hidden');
  }
}

export function parseHTML(htmlText) {
  const parser = new DOMParser();
  return parser.parseFromString(htmlText, 'text/html').body.firstChild;
}

export function swalConfirmDelete(prompt, descriptionText, action, confirmButtonText = 'Yes, delete.') {
  Swal.fire({
    title: prompt,
    text: descriptionText,
    icon: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#ff0000',
    cancelButtonColor: '#aaa',
    confirmButtonText: confirmButtonText
  }).then(result => {
    if (result.isConfirmed) {
      action();
    }
  });
}
