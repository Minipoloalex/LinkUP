const imageInput = document.querySelectorAll('.file-input-wrapper input[type="file"]');
imageInput.forEach(changeEventListener);

const cropperContainer = document.getElementById('cropper-container');
const cropperImage = document.getElementById('cropper-image');


function changeEventListener(imageInput) {
    console.log('adding evnet elistener');
    imageInput.addEventListener('change', function (e) {
        console.log('event listener fired');
        const file = e.target.files[0];
        if (file) {
            var reader = new FileReader();
            reader.onload = function (e) {
                cropperImage.src = e.currentTarget.result;

                // Show the Cropper container
                show(cropperContainer);

                // Initialize Cropper.js
                const cropper = new Cropper(cropperImage, {
                    // aspectRatio: 1, // 1:1 aspect ratio for a square crop
                    // viewMode: 1,    // Restricts the crop box to always cover the container
                    aspectRatio: NaN,
                    cropBoxResizable: false, // Disable resizing
                    autoCropArea: 1, // Always crop the full image
                    dragMode: 'move',
                    crop(event) {
                        console.log('crop event fired');
                        console.log(event.detail.x);
                        console.log(event.detail.y);
                        console.log(event.detail.width);
                        console.log(event.detail.height);
                        console.log(event.detail.rotate);
                        console.log(event.detail.scaleX);
                        console.log(event.detail.scaleY);
                    },
                });

                // Handle the crop button click
                document.getElementById('cropButton').addEventListener('click', function () {
                    // Get the cropped image data
                    const croppedData = cropper.getData();
                    console.log('Cropped Data:', croppedData);

                    // You can send the cropped data to the server for further processing

                    // Hide the Cropper container
                    hide(cropperContainer);
                });
            };
            reader.readAsDataURL(file);
        }
    });
}
