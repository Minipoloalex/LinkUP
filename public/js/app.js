import { addFollowRequestEvents } from './notifications/notifications.js'

const mobileSidebar = document.getElementById('mobile-sidebar')
const mobileToggleSidebar = document.getElementById('mobile-show-sidebar')
const translate = 'translate-x-[70vw]'
if (mobileSidebar) {
  mobileSidebar.classList.remove(translate)
}

if (mobileToggleSidebar) {
  mobileToggleSidebar.addEventListener('click', () => {
    mobileSidebar.classList.remove('invisible')
    mobileSidebar.classList.toggle(translate)
  })

  const main = document.querySelector('main')
  main.addEventListener('click', e => {
    if (!mobileSidebar.classList.contains(translate)) return
    if (
      !mobileSidebar.contains(e.target) &&
      !mobileToggleSidebar.contains(e.target)
    ) {
      e.preventDefault()
      mobileSidebar.classList.remove(translate)
    }
  })
}

addFollowRequestEvents(document)
