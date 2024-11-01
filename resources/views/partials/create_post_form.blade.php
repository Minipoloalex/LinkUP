{{--
['formClass' => string, 'type' => string, 'textPlaceholder' => string, 'buttonText' => string, 'contentValue' => string,
'headerText' => ?string]
--}}
@php
$headerText ??= null;
$zValue ??= 30;
@endphp
<form
    class="{{$formClass}} relative flex flex-col w-full rounded-md dark:bg-dark-primary border-2 dark:border-dark-neutral p-5 z-{{$zValue}} gap-2 pointer-events-auto">
    <section data-type="post" class="file-input-wrapper">
        @if ($headerText !== null)
        <header>
            <h2 class="mb-4">{{ $headerText }}</h2>
        </header>
        @endif
        <textarea name="content" required placeholder="{{ $textPlaceholder }}"
            class="dark:bg-dark-primary border dark:border-dark-neutral outline-dark-active w-full h-[10vh] p-2 pb-8 resize-none text-sm">{{ $contentValue }}</textarea>
        <div class="w-full flex justify-center">
            <div class="relative">
                <img class="image-preview w-[20vh] mb-4 hidden" src="" alt="Post image preview">
                <button
                    class="remove-file hidden dark:bg-dark-neutral dark:text-dark-secondary rounded-full h-6 w-6 absolute top-1 right-1 ring-1 dark:ring-dark-secondary">
                    <i class="fas fa-times"></i>
                </button>
            </div>
        </div>
        <div class="flex justify-between items-center">
            <button type="submit" {{-- MUST BE FIRST ON THE HTML --}}
                class="order-last dark:bg-dark-active dark:text-dark-secondary rounded-full py-2 px-6">
                {{ $buttonText }}
            </button>
            <div class="flex">
                <button class="upload-file ml-1 dark:bg-dark-primary dark:text-dark-active">
                    <i class="fas fa-image text-2xl"></i>
                </button>
                <input type="file" accept="image/*" name="media" class="hidden">
                @include('partials.images_crop_input')
            </div>
        </div>
    </section>
</form>
<div class="z-30"></div>
<div class="z-40"></div>