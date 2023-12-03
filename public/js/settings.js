const accountSettings = document.getElementById('account-settings')
const accountSettingsToggle = document.getElementById('account-settings-toggle')

const profileSettings = document.getElementById('profile-settings')
const profileSettingsToggle = document.getElementById('profile-settings-toggle')

const activeSection = document.getElementById('active-section')

if (accountSettingsToggle) {
  accountSettingsToggle.addEventListener('click', () => {
    accountSettingsToggle.classList.add('border-b-2')
    accountSettingsToggle.classList.add('border-black')

    profileSettingsToggle.classList.remove('border-b-2')
    profileSettingsToggle.classList.remove('border-black')

    // show the account settings
    accountSettings.classList.remove('hidden')

    // hide the profile settings
    profileSettings.classList.add('hidden')
  })
}
if (profileSettingsToggle) {
  profileSettingsToggle.addEventListener('click', () => {
    profileSettingsToggle.classList.add('border-b-2')
    profileSettingsToggle.classList.add('border-black')

    accountSettingsToggle.classList.remove('border-b-2')
    accountSettingsToggle.classList.remove('border-black')

    // show the profile settings
    profileSettings.classList.remove('hidden')

    // hide the account settings
    accountSettings.classList.add('hidden')
  })
}
