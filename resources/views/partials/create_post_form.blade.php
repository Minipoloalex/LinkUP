{{-- 
['formClass' => string, 'type' => string, 'textPlaceholder' => string, 'buttonText' => string, 'contentValue' => string]
--}}

<form class="{{$formClass}} flex flex-col">
    <textarea name="content" required placeholder="{{ $textPlaceholder }}" class="p-2 bg-gray-600 rounded text-white focus:outline-none focus:bg-gray-700 w-full">{{ $contentValue }}</textarea>
    <button type="submit" class="order-last bg-gray-500 rounded px-4 py-2 mx-5 text-white">{{ $buttonText }}</button>     {{-- MUST BE FIRST ON THE HTML --}}
    @include('partials.file_input')
</form>
