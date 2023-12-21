const accountSettingsForm = document.getElementById('account-settings-form');
const accountUpdateButton = document.getElementById('account-update-button');

const accountDeleteForm = document.getElementById('account-delete-form');
const accountDeleteButton = document.getElementById('account-delete-button');

// asks for the current password before updating the account settings
if (accountUpdateButton) {
    accountUpdateButton.addEventListener('click', (e) => {
        e.preventDefault(); 

        Swal.fire({
            title: '<h1 class="text-dark-active">Enter your password</h1>',
            html: '<p class="text-white">This is required to update your account settings</p>',
            input: 'password',
            inputAttributes: {
                autocapitalize: 'off'
            },
            background: '#333333',
            showCancelButton: true,
            confirmButtonText: 'Update',
            confirmButtonColor: '#A58AD6',
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

    // asks for the current password before deleting the account
    accountDeleteButton.addEventListener('click', (e) => {
        e.preventDefault(); 

        Swal.fire({
            title: '<h1 class="text-dark-active">Enter your password</h1>',
            html: '<p class="text-white">This is required to delete your account</p>',
            input: 'password',
            inputAttributes: {
                autocapitalize: 'off'
            },
            background: '#333333',
            showCancelButton: true,
            confirmButtonText: 'Delete',
            confirmButtonColor: '#EF4444',
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
                // delete the account
                accountDeleteForm.submit();
            }
        })
    });
}
