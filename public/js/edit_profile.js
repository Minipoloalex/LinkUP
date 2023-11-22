const editButton = document.getElementById('editButton');
const editModal = document.getElementById('editModal');
// const editForm = document.getElementById('editForm');
if (editButton && editModal) {
    const closeModalButton = editModal.querySelector('.modal-content button[type="button"]');

    // Function to open the edit modal
    function openEditModal() {
        editModal.classList.remove('hidden');
        document.body.style.overflow = 'hidden'; // Prevent scrolling when modal is open
    }

    // Function to close the edit modal
    function closeEditModal() {
        editModal.classList.add('hidden');
        document.body.style.overflow = ''; // Enable scrolling when modal is closed
    }

    // Handle click events on the Edit button
    editButton.addEventListener('click', function() {
        openEditModal();
    });

    // Handle click events on the Cancel button inside the modal
    closeModalButton.addEventListener('click', function() {
        closeEditModal();
    });
}
