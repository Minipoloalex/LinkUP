const fileInputWrappers = document.querySelectorAll('.file-input-wrapper');
fileInputWrappers.forEach(handlerFileInput);

function getFileInputWrapper(form) {
    return form.querySelector('.file-input-wrapper');
}
function clearFileInputWrapper(fileInputWrapper) {
    const removeFileBtn = getRemoveFileBtn(fileInputWrapper);
    removeFileBtn.click();
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
    const width = fileInputWrapper.querySelector('input[name="width"]');
    const height = fileInputWrapper.querySelector('input[name="height"]');
    const x = fileInputWrapper.querySelector('input[name="x"]');
    const y = fileInputWrapper.querySelector('input[name="y"]');

    const cropperContainer = fileInputWrapper.querySelector('.cropper-container');
    const cropperImage = fileInputWrapper.querySelector('.cropper-image');
    const cropButton = fileInputWrapper.querySelector('.crop-button');

    const fileName = getFileName(fileInputWrapper);
    const removeFileBtn = getRemoveFileBtn(fileInputWrapper);
    const uploadFileBtn = getUploadFileBtn(fileInputWrapper);

    const clearFile = () => {
        clearFileInput(fileName, removeFileBtn, uploadFileBtn);
        hide(cropperContainer);
    }
    let cropper = null;
    fileInput.addEventListener('change', () => {
        if (fileInput.files.length > 0) {
            fileName.textContent = fileInput.files[0].name;
            show(removeFileBtn);
            hide(uploadFileBtn);
            const reader = new FileReader();
            reader.onload = function (e) {
                cropperImage.src = e.currentTarget.result;
                if (cropper) {
                    console.log("Destroying");
                    cropper.destroy();
                }
                cropper = new Cropper(cropperImage, {
                    aspectRatio: 1,
                    cropBoxResizable: false,
                    dragMode: 'move',
                });
                show(cropperContainer);
            };
            reader.readAsDataURL(fileInput.files[0]);
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
    cropButton.addEventListener('click', (event) => {
        event.preventDefault();
        if (cropper) {
            const canvas = cropper.getData(rounded=true);
            x.value = canvas.x;
            y.value = canvas.y;
            width.value = canvas.width;
            height.value = canvas.height;
            
            hide(cropperContainer);
        }
    });
}
