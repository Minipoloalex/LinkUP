
function handlerFileInput(fileInputWrapper) {
    const fileInput = fileInputWrapper.querySelector('input[type="file"]');

    const fileName = fileInputWrapper.querySelector('.file-name');
    const removeFileBtn = fileInputWrapper.querySelector('.remove-file');
    const uploadFileBtn = fileInputWrapper.querySelector('.upload-file');

    const clearFileInput = () => {
        fileName.textContent = 'No file selected';
        removeFileBtn.classList.add('hidden');
        uploadFileBtn.classList.remove('hidden');
    }

    fileInput.addEventListener('change', () => {
        if (fileInput.files.length > 0) {
          fileName.textContent = fileInput.files[0].name;
          removeFileBtn.classList.remove('hidden');
          uploadFileBtn.classList.add('hidden');
        } else {
            clearFileInput();
        }
    });
    removeFileBtn.addEventListener('click', (event) => {
        event.preventDefault();
        fileInput.value = null;
        clearFileInput();
    });
    uploadFileBtn.addEventListener('click', (event) => {
        event.preventDefault();
        console.log('clicked button to upload file');
        fileInput.click();
    });
}

const fileInputWrappers = document.querySelectorAll('.file-input-wrapper');
fileInputWrappers.forEach(handlerFileInput);
