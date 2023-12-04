import { show, hide } from './general_helpers.js'

const editButton = document.getElementById('editButton')
const editModal = document.getElementById('editModal')
// const editForm = document.getElementById('editForm');
if (editButton && editModal) {
  const closeModalButton = editModal.querySelector(
    '.modal-content button[type="button"]'
  )
  const editForm = document.getElementById('editForm')
  const darkOverlay = document.getElementById('dark-overlay')

  // Function to open the edit modal
  function openEditModal () {
    show(editModal)
    document.body.style.overflow = 'hidden' // Prevent scrolling when modal is open
    show(darkOverlay) // Show dark overlay
  }

  // Function to close the edit modal
  function closeEditModal () {
    hide(editModal)
    document.body.style.overflow = '' // Enable scrolling when modal is closed
    hide(darkOverlay) // Hide dark overlay
  }

  // Handle click events on the Edit button
  editButton.addEventListener('click', function () {
    openEditModal()
  })

  // Handle click events on the Cancel button inside the modal
  closeModalButton.addEventListener('click', function () {
    closeEditModal()
  })
}
