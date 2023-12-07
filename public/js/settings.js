const accountSettings = document.getElementById('account-settings');
const accountSettingsToggle = document.getElementById('account-settings-toggle');

const profileSettings = document.getElementById('profile-settings');
const profileSettingsToggle = document.getElementById('profile-settings-toggle');

const accountSettingsForm = document.getElementById('account-settings-form');
const accountUpdateButton = document.getElementById('account-update-button');

accountSettingsToggle.addEventListener('click', () => {
    accountSettingsToggle.classList.add('border-b-2');
    accountSettingsToggle.classList.add('border-black');
    
    profileSettingsToggle.classList.remove('border-b-2');
    profileSettingsToggle.classList.remove('border-black');

    // show the account settings
    accountSettings.classList.remove('hidden');

    // hide the profile settings
    profileSettings.classList.add('hidden');
});


profileSettingsToggle.addEventListener('click', () => {
    profileSettingsToggle.classList.add('border-b-2');
    profileSettingsToggle.classList.add('border-black');

    accountSettingsToggle.classList.remove('border-b-2');
    accountSettingsToggle.classList.remove('border-black');

    // show the profile settings
    profileSettings.classList.remove('hidden');

    // hide the account settings
    accountSettings.classList.add('hidden');

});

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