const accountSettingsForm = document.getElementById('account-settings-form');
const accountUpdateButton = document.getElementById('account-update-button');

// asks for the current password before updating the account settings
accountUpdateButton.addEventListener('click', (e) => {
    e.preventDefault(); 

    Swal.fire({
        title: 'Enter your password',
        text: 'This is required to update your account settings',
        input: 'password',
        inputAttributes: {
            autocapitalize: 'off'
        },
        showCancelButton: true,
        confirmButtonText: 'Update',
        confirmButtonColor: '#3B82F6',
        showLoaderOnConfirm: true,
        
        preConfirm: (password) => {
            return fetch('/settings/confirm-password', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                },
                body: JSON.stringify({ password })
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error(response.statusText)
                }
                return response.json()
            })
            .catch(error => {
                Swal.showValidationMessage(
                    'Incorrect password'
                )
            })
        },
        allowOutsideClick: () => !Swal.isLoading()
    }).then((result) => {
        if (result.isConfirmed) {
            // update the account settings
            accountSettingsForm.submit();
        }
    })
});