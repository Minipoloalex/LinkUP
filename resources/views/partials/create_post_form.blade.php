{{-- 
['formClass' => string, 'type' => string, 'textPlaceholder' => string, 'buttonText' => string, 'contentValue' => string]
--}}

<form class="{{$formClass}} fixed bottom-0 left-1/2 transform -translate-x-1/2">
    <input type="text" name="content" required placeholder="{{ $textPlaceholder }}" value="{{ $contentValue }}">
    <button type="submit">{{ $buttonText }}</button>     {{-- MUST BE FIRST ON THE HTML --}}
    <div class="file-input-wrapper">
        <button class="upload-file">Upload image</button>
        <input type="file" accept=".jpg, .jpeg, .png, .gif, .mp4" class="hidden" name="media">
        <button class="remove-file hidden">Clear image</button>
        <span class="file-name">No file selected</span>
    </div>
</form>
