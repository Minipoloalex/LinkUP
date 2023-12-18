{{--
['formClass' => string, 'type' => string, 'textPlaceholder' => string, 'buttonText' => string, 'contentValue' => string]
--}}

<form
    class="{{$formClass}} relative add-post flex flex-col w-full rounded-md dark:bg-dark-primary border-2 dark:border-dark-neutral p-5 z-30 gap-2 pointer-events-auto">
    <div data-type="post" class="file-input-wrapper">
        <textarea name="content" required placeholder="{{ $textPlaceholder }}"
            class="dark:bg-dark-primary border dark:border-dark-neutral outline-dark-active w-full h-[10vh] p-2 pb-8 resize-none text-sm">{{ $contentValue }}</textarea>
        <div class="w-full flex justify-center">
            <div class="relative">
                <img id="image-preview" class="w-[20vh] mb-4 hidden" src="" alt="Post image preview">
                <button id="remove-file"
                    class="hidden dark:bg-dark-neutral dark:text-dark-secondary rounded-full h-6 w-6 absolute top-1 right-1 ring-1 dark:ring-dark-secondary">
                    <i class="fas fa-times"></i>
                </button>
            </div>
        </div>
        <div class="flex justify-between items-center">
            <button type="submit"
                class="order-last dark:bg-dark-active dark:text-dark-secondary rounded-full py-2 px-6">
                {{ $buttonText }}
            </button>
            {{-- MUST BE FIRST ON THE HTML --}}
            <div class="flex">
                <button class="upload-file ml-1 -mt-4 dark:bg-dark-primary dark:text-dark-active">
                    <i class="fas fa-image text-2xl"></i>
                </button>
                <input type="file" accept="image/*" name="media" class="hidden">
                @include('partials.images_crop_input')
            </div>
        </div>
    </div>
</form>