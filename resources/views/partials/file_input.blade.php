<div class="file-input-wrapper">
    <button class="upload-file bg-gray-500 rounded px-4 py-2 m-6 text-white">Upload image</button>
    <input type="file" accept=".jpg, .jpeg, .png, .gif, .mp4" name="media" class="hidden">
    <input type="hidden" name="x">
    <input type="hidden" name="y">
    <input type="hidden" name="width">
    <input type="hidden" name="height">
    <button class="remove-file hidden bg-gray-500 rounded px-4 py-2 m-6 text-white">Clear image</button>
    <span class="file-name">No file selected</span>
    <div class="cropper-container hidden max-h-96">
        <img class="cropper-image block max-w-full" src="_" alt="Profile Picture">
    </div>
    <button class="crop-button">Crop</button>
</div>
