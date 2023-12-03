<div class="file-input-wrapper">
    <button class="upload-file bg-gray-500 rounded px-4 py-2 m-6 text-white">Upload image</button>
    <input type="file" accept=".jpg, .jpeg, .png, .gif, .mp4" name="media" class="hidden">
    <button class="remove-file hidden bg-gray-500 rounded px-4 py-2 m-6 text-white">Clear image</button>
    <span class="file-name">No file selected</span>
</div>
<div id="cropper-container" class="hidden">
    <img class="block max-w-full" id="cropper-image" src="#" alt="Profile Picture">
</div>
<button id="cropButton">Crop and Save</button>
