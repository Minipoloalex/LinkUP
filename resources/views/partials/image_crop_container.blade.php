
<div class="crop-image-container fixed hidden">  {{-- class defined for our JS --}}
    <div class="cropper-container hidden max-h-96"> {{-- class defined for cropperjs --}}
        <img class="cropper-image block max-w-full" src="" alt="Profile Picture">
    </div>
    <button class="crop-button bg-gray-300 hover:bg-gray-400 text-black font-bold py-2 px-4 rounded-full mr-1 mt-1">Crop</button>
    {{-- TODO: remove hidden from crop-button--}}
    <button class="cancel-crop">Cancel</button>
</div>
