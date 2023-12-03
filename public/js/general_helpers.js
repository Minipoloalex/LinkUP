function hide (element) {
  if (element) {
    element.classList.add('hidden')
  }
}
function show (element) {
  if (element) {
    element.classList.remove('hidden')
  }
}
export function parseHTML (htmlText) {
  const parser = new DOMParser()
  return parser.parseFromString(htmlText, 'text/html').body.firstChild
}
