function hideSuccessMessage() {
    const successMessage = document.querySelector('.success');
    if (successMessage) {
        setTimeout(() => {
            successMessage.style.display = 'none';
        }, 5000);
    }
}

function hideErrorMessage() {
    const errorMessage = document.querySelector('.error');
    if (errorMessage) {
        setTimeout(() => {
            errorMessage.style.display = 'none';
        }, 5000);
    }
}

hideSuccessMessage();
hideErrorMessage(); 