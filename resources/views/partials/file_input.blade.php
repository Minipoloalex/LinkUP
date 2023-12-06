<div class="file-input-wrapper">
    <button class="upload-file bg-gray-500 rounded px-4 py-2 m-6 text-white">Upload image</button>
    <input type="file" accept=".jpg, .jpeg, .png, .gif" name="media" class="hidden">
    <input type="hidden" name="x">
    <input type="hidden" name="y">
    <input type="hidden" name="width">
    <input type="hidden" name="height">
    <button class="remove-file hidden bg-gray-500 rounded px-4 py-2 m-6 text-white">Clear image</button>
    <div class="cropper-container hidden max-h-96">
        <img class="cropper-image block max-w-full" src="" alt="Profile Picture">
    </div>
    <button class="crop-button hidden bg-gray-300 hover:bg-gray-400 text-black font-bold py-2 px-4 rounded-full mr-1 mt-1">Crop</button>
    @include('partials.image_crop_container')
</div>
