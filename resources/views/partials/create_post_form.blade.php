{{-- 
['formClass' => string, 'type' => string, 'textPlaceholder' => string, 'buttonText' => string, 'contentValue' => string]
--}}

<form class="{{$formClass}}">
    <input type="text" name="content" required placeholder="{{ $textPlaceholder }}" value="{{ $contentValue }}" class="p-2 bg-gray-600 rounded text-white focus:outline-none focus:bg-gray-700">
    <button type="submit" class="bg-gray-500 rounded px-4 py-2 mx-5 text-white">{{ $buttonText }}</button>     {{-- MUST BE FIRST ON THE HTML --}}
    <div class="file-input-wrapper">
        <button class="upload-file bg-gray-500 rounded px-4 py-2 m-6 text-white">Upload image</button>
        <input type="file" accept=".jpg, .jpeg, .png, .gif, .mp4" name="media" class="hidden">
        <button class="remove-file hidden bg-gray-500 rounded px-4 py-2 m-6 text-white">Clear image</button>
        <span class="file-name">No file selected</span>
    </div>
</form>
