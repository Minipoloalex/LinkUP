document.addEventListener('DOMContentLoaded', function() {
    const editButton = document.getElementById('editButton');
    const editModal = document.getElementById('editModal');
    const closeModalButton = editModal.querySelector('.modal-content button[type="button"]');
    const editForm = document.getElementById('editForm');

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

    // Handle form submission
    editForm.addEventListener('submit', function(event) {
        event.preventDefault();
        // Here you can handle form submission
        // Retrieve new name and username values from inputs
        const newName = document.getElementById('name').value;
        const newUsername = document.getElementById('username').value;
        // Perform actions to update profile with the new values
        // Close the modal after successful submission or perform relevant actions
        closeEditModal();
    });
});
