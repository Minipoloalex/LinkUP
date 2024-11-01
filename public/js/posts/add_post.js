import { submitAddPostOrComment, getTextField } from './post_helpers.js'
import { clearFileInputWrapper, getFileInputWrapper } from '../file_input.js'
import { hide, show, parseHTML } from '../general_helpers.js'
import { prependPostToTimeline } from '../home/home.js'
import { prependInPostSection } from '../group/group.js'
import { addEventListenersToPost } from './post_event_listeners.js'

const addPostOn = document.querySelector('.add-post-on')
const addPostForm = document.querySelector('form.add-post')
const darkOverlay = document.getElementById('dark-overlay')
const wrapper = document.getElementById('create-post')

const groupIdElement = document.getElementById('group-id')

if (addPostOn) {
  addPostOn.addEventListener('click', showAddPostForm)
}

function showAddPostForm (event) {
  event.preventDefault()
  show(wrapper)
  show(addPostForm)
  show(darkOverlay)
  if (darkOverlay) {
    darkOverlay.addEventListener('click', cleanAddPostForm)
  }
  if (addPostForm) {
    addPostForm.addEventListener('submit', submitAddPost)
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
  hide(wrapper)
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
    const postElement = parseHTML(data.postHTML)
    if (groupId != null) {
      prependInPostSection(postElement)
    } else {
      prependPostToTimeline(postElement)
    }
    addEventListenersToPost(postElement)
    addPostForm.reset()
    clearFileInputWrapper(getFileInputWrapper(addPostForm))
  }
}
