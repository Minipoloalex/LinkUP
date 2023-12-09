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

export async function swalConfirmDelete(prompt, descriptionText, action, cancelAction, confirmButtonText = 'Yes, delete.') {
  const result = await Swal.fire({
    title: prompt,
    text: descriptionText,
    icon: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#ff0000',
    cancelButtonColor: '#aaa',
    confirmButtonText: confirmButtonText
  });
  if (result.isConfirmed) {
    await action();
    return true;
  }
  if (cancelAction) {
    await cancelAction();
  }
  return false;
}
