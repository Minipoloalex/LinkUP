import { show, hide } from "./general_helpers.js";

const fileInputWrappers = document.querySelectorAll('.file-input-wrapper');
fileInputWrappers.forEach(handlerFileInput);

export function getFileInputWrapper(form) {
    return form.querySelector('.file-input-wrapper');
}
export function clearFileInputWrapper(fileInputWrapper) {
    const removeFileBtn = getRemoveFileBtn(fileInputWrapper);
    if (removeFileBtn) removeFileBtn.click();
}
function getRemoveFileBtn(fileInputWrapper) {
    return fileInputWrapper.querySelector('.remove-file');
}
function getUploadFileBtn(fileInputWrapper) {
    return fileInputWrapper.querySelector('.upload-file');
}
function getImagePreview(fileInputWrapper) {
    return fileInputWrapper.querySelector('.image-preview');
}
function getDataType(fileInputWrapper) {
    return fileInputWrapper.dataset.type;
}
export function handlerFileInput(fileInputWrapper) {
    const fileInput = fileInputWrapper.querySelector('input[type="file"]');
    const width = fileInputWrapper.querySelector('input[name="width"]');
    const height = fileInputWrapper.querySelector('input[name="height"]');
    const x = fileInputWrapper.querySelector('input[name="x"]');
    const y = fileInputWrapper.querySelector('input[name="y"]');

    const removeFileBtn = getRemoveFileBtn(fileInputWrapper);
    const uploadFileBtn = getUploadFileBtn(fileInputWrapper);

    const clearFile = () => {
        fileInput.value = null;
        hide(removeFileBtn);
        show(uploadFileBtn);
    }
    const type = getDataType(fileInputWrapper);
    fileInput.addEventListener('change', () => {
        if (fileInput.files.length > 0) {
            show(removeFileBtn);
            hide(uploadFileBtn);
            const reader = new FileReader();
            reader.onload = function (e) {
                const imgSource = e.currentTarget.result;
                showCropSwal(imgSource).then(
                    (result) => {
                        if (result.isConfirmed) {
                            x.value = result.value.data.x;
                            y.value = result.value.data.y;
                            width.value = result.value.data.width;
                            height.value = result.value.data.height;

                            const img = getImagePreview(fileInputWrapper);
                            img.src = result.value.preview;

                            show(removeFileBtn);
                            hide(uploadFileBtn);
                            if (type === 'post') {
                                show(img);
                            }
                        }
                        else {
                            clearFile();
                            if (type === 'post') {
                                hide(img);
                            }
                        }
                    }
                );
            };
            reader.readAsDataURL(fileInput.files[0]);
        } else {    // no files in input
            if (type === 'post') {
                hide(getImagePreview(fileInputWrapper));
            }
            hide(removeFileBtn);
            show(uploadFileBtn);
        }
    });
    if (removeFileBtn) {
        removeFileBtn.addEventListener('click', (event) => {
            event.preventDefault();
            clearFile();
            if (type == 'post') {
                hide(getImagePreview(fileInputWrapper));
            }
        });
    }
    if (uploadFileBtn) {
        uploadFileBtn.addEventListener('click', (event) => {
            event.preventDefault();
            fileInput.click();
        });
    }
}


async function showCropSwal(imageSrc) {
    let cropper = null;
    return await Swal.fire({
        title: 'Crop your image',
        html: `
        <div class="flex justify-center">
            <img id="preview" src="${imageSrc}">
        </div>
        <div>
            <img id="cropperjs" src="${imageSrc}">
        </div>
        `,
        willOpen: () => {
            const image = Swal.getPopup().querySelector('#cropperjs');
            let timeoutId;
            cropper = new Cropper(image, {
                aspectRatio: 1,
                viewMode: 1,
                dragMode: 'move',
                crop: () => {
                    clearTimeout(timeoutId);
                    timeoutId = setTimeout(() => {
                        if (cropper) {
                            const croppedCanvas = cropper.getCroppedCanvas();
                            const popup = Swal.getPopup();
                            if (popup) {
                                const preview = popup.querySelector('#preview');
                                preview.src = croppedCanvas.toDataURL();
                            }
                        }
                    }, 25);
                },
            });
        },
        preConfirm: () => {
            return {
                data: cropper.getData(true),
                preview: (Swal.getPopup().querySelector('#preview')).src,
            };
        },
        showCancelButton: true,
        showConfirmButton: true,
        confirmButtonText: 'Crop',
        // confirmButtonColor: '#ff0000',   // TODO: change color
        cancelButtonText: 'Cancel',
        // cancelButtonColor: '#aaa',
    });
}
