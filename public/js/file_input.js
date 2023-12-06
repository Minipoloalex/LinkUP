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
function clearFileInput(removeFileBtn, uploadFileBtn) {
    hide(removeFileBtn);
    show(uploadFileBtn);
}
function getRemoveFileBtn(fileInputWrapper) {
    return fileInputWrapper.querySelector('.remove-file');
}
function getUploadFileBtn(fileInputWrapper) {
    return fileInputWrapper.querySelector('.upload-file');
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
        clearFileInput(removeFileBtn, uploadFileBtn);
    }
    let cropper = null;
    fileInput.addEventListener('change', () => {
        if (fileInput.files.length > 0) {
            show(removeFileBtn);
            hide(uploadFileBtn);
            const reader = new FileReader();
            reader.onload = function (e) {
                const imgSource = e.currentTarget.result;
                console.log("Showing crop swal");
                showCropSwal(imgSource).then(
                    (result) => {
                        if (result.isConfirmed) {
                            x.value = result.value.data.x;
                            y.value = result.value.data.y;
                            width.value = result.value.data.width;
                            height.value = result.value.data.height;
                            const img = fileInputWrapper.querySelector('.image-preview')
                            img.src = result.value.preview;
                        }
                        else {
                            fileInput.value = null;
                            clearFile();
                        }
                    }
                );
            };
            reader.readAsDataURL(fileInput.files[0]);
        } else {
            clearFile();
        }
    });
    if (removeFileBtn) {
        removeFileBtn.addEventListener('click', (event) => {
            event.preventDefault();
            fileInput.value = null;
            clearFile();
        });
    }
    if (uploadFileBtn) {
        uploadFileBtn.addEventListener('click', (event) => {
            event.preventDefault();
            fileInput.click();
        });
    }
    // cropButton.addEventListener('click', (event) => {
    //     event.preventDefault();
    //     if (cropper) {
    //         const canvas = cropper.getData(true);
    //         x.value = canvas.x;
    //         y.value = canvas.y;
    //         width.value = canvas.width;
    //         height.value = canvas.height;
            
    //         hide(cropperContainer);
    //         hide(cropButton);
    //     }
    // });
}


async function showCropSwal(imageSrc) {
    let cropper = null;
    const res = await Swal.fire({
        title: 'Crop your image',
        html: `
        <div class="flex justify-center">
            <img id="preview" class="" src="${imageSrc}">
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
                        const croppedCanvas = cropper.getCroppedCanvas();
                        const preview = Swal.getPopup().querySelector('#preview');
                        preview.src = croppedCanvas.toDataURL();
                    }, 25);
                },
            });
        },
        preConfirm: () => {
            console.log(cropper.getData(true));
            // return cropper.getData(true);
            return {
                data: cropper.getData(true),
                preview: (Swal.getPopup().querySelector('#preview')).src,
            };
            // return (Swal.getPopup().querySelector('#preview')).src
        },
        showCancelButton: true,
        showConfirmButton: true,
        confirmButtonText: 'Crop',
        // confirmButtonColor: '#ff0000',
        cancelButtonText: 'Cancel',
        // cancelButtonColor: '#aaa',
    });
    console.log(res);
    return res;
}
