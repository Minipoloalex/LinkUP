import { submitAddPostOrComment, getTextField } from './post_helpers.js'
import { clearFileInputWrapper, getFileInputWrapper } from '../file_input.js'
import { hide, show, parseHTML } from '../general_helpers.js'
import { prependPostsToTimeline } from '../home/home.js'
import { prependInPostSection } from '../group/group.js'

const addPostOn = document.querySelector('.add-post-on')
const addPostForm = document.querySelector('form.add-post')
const darkOverlay = document.getElementById('dark-overlay')

const groupIdElement = document.getElementById('group-id')

if (addPostOn) {
  addPostOn.addEventListener('click', showAddPostForm)
}

function showAddPostForm (event) {
  event.preventDefault()
  show(addPostForm)
  show(darkOverlay)
  if (addPostForm) {
    addPostForm.addEventListener('submit', submitAddPost)
  }
  if (darkOverlay) {
    darkOverlay.addEventListener('click', cleanAddPostForm)
  }
  getTextField(addPostForm).focus()
}
function cleanAddPostForm () {
  addPostForm.reset()
  clearFileInputWrapper(getFileInputWrapper(addPostForm))
  hideAddPostForm()
}

function hideAddPostForm () {
  hide(addPostForm)
  show(addPostOn)
  hide(darkOverlay)
}

async function submitAddPost (event) {
  event.preventDefault()
  const content = getTextField(addPostForm).value
  const requestBody = { content: content }

  const groupId =
    groupIdElement != null ? groupIdElement.getAttribute('value') : null
  if (groupId != null) {
    requestBody.id_group = groupId
  }

  hideAddPostForm()
  const data = await submitAddPostOrComment(addPostForm, requestBody, 'post')
  if (data != null) {
    if (groupId != null) {
      const postElement = parseHTML(data.postHTML)
      prependInPostSection(postElement)
    } else {
      prependPostsToTimeline([data.postHTML])
    }
    addPostForm.reset()
    clearFileInputWrapper(getFileInputWrapper(addPostForm))
  }
}
