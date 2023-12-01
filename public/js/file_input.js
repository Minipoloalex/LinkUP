function clearFileInputWrapper(fileInputWrapper) {
    const fileName = fileInputWrapper.querySelector('.file-name');
    const removeFileBtn = fileInputWrapper.querySelector('.remove-file');
    const uploadFileBtn = fileInputWrapper.querySelector('.upload-file');
    clearFileInput(fileName, removeFileBtn, uploadFileBtn);
}
function clearFileInput(fileName, removeFileBtn, uploadFileBtn) {
    fileName.textContent = 'No file selected';
    hide(removeFileBtn);
    show(uploadFileBtn);
}
function getFileName(fileInputWrapper) {
    return fileInputWrapper.querySelector('.file-name');
}
function getRemoveFileBtn(fileInputWrapper) {
    return fileInputWrapper.querySelector('.remove-file');
}
function getUploadFileBtn(fileInputWrapper) {
    return fileInputWrapper.querySelector('.upload-file');
}
function handlerFileInput(fileInputWrapper) {
    const fileInput = fileInputWrapper.querySelector('input[type="file"]');

    const fileName = getFileName(fileInputWrapper);
    const removeFileBtn = getRemoveFileBtn(fileInputWrapper);
    const uploadFileBtn = getUploadFileBtn(fileInputWrapper);

    const clearFile = () => {
        clearFileInput(fileName, removeFileBtn, uploadFileBtn);
    }
    fileInput.addEventListener('change', () => {
        if (fileInput.files.length > 0) {
            fileName.textContent = fileInput.files[0].name;
            show(removeFileBtn);
            hide(uploadFileBtn);
        } else {
            clearFile();
        }
    });
    removeFileBtn.addEventListener('click', (event) => {
        event.preventDefault();
        fileInput.value = null;
        clearFile();
    });
    uploadFileBtn.addEventListener('click', (event) => {
        event.preventDefault();
        fileInput.click();
    });
}
const fileInputWrappers = document.querySelectorAll('.file-input-wrapper');
fileInputWrappers.forEach(handlerFileInput);
