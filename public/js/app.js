// // On page load or when changing themes, best to add inline in `head` to avoid FOUC
// if (localStorage.theme === 'dark' || (!('theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
//     document.documentElement.classList.add('dark')
//   } else {
//     document.documentElement.classList.remove('dark')
//   }

//   // Whenever the user explicitly chooses light mode
//   localStorage.theme = 'light'

//   // Whenever the user explicitly chooses dark mode
//   localStorage.theme = 'dark'

//   // Whenever the user explicitly chooses to respect the OS preference
//   localStorage.removeItem('theme')

const mobileSidebar = document.getElementById('mobile-sidebar')
const mobileToggleSidebar = document.getElementById('mobile-show-sidebar')
const translate = 'translate-x-[70vw]'
mobileSidebar.classList.remove(translate)

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
