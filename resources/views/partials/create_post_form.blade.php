{{-- 
['formClass' => string, 'type' => string, 'textPlaceholder' => string, 'buttonText' => string, 'contentValue' => string]
--}}

<form class="{{$formClass}} flex flex-col">
    <textarea name="content" required placeholder="{{ $textPlaceholder }}" class="p-2 bg-gray-600 rounded text-white focus:outline-none focus:bg-gray-700 w-full">{{ $contentValue }}</textarea>
    <button type="submit" class="order-last bg-gray-500 rounded px-4 py-2 mx-5 text-white">{{ $buttonText }}</button>     {{-- MUST BE FIRST ON THE HTML --}}
    <div class="file-input-wrapper" data-type="post">
        <button class="upload-file bg-gray-500 rounded px-4 py-2 m-6 text-white">Upload image</button>
        <button class="remove-file hidden bg-gray-500 rounded px-4 py-2 m-6 text-white">Clear image</button>
        <img class="image-preview w-full mb-4 hidden" src="" alt="Post image preview">
        <input type="file" accept="image/*" name="media" class="hidden">
        @include('partials.images_crop_input')
    </div>
</form>
