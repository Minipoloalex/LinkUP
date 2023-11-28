function hideSuccessMessage() {
    const successMessage = document.querySelector('.success');
    if (successMessage) {
        setTimeout(() => {
            successMessage.style.display = 'none';
        }, 3000);
    }
}

function hideErrorMessage() {
    const errorMessage = document.querySelector('.error');
    if (errorMessage) {
        setTimeout(() => {
            errorMessage.style.display = 'none';
        }, 3000);
    }
}

hideSuccessMessage();
hideErrorMessage(); 