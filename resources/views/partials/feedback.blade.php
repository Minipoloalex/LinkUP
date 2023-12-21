@php
$feedback = session('feedback');
$hidden = isset($feedback);
$translate = $hidden ? 'feedback-active' : '';
@endphp
<footer id="feedback-message" class="z-50 fixed -bottom-12 left-[10vw] w-[80vw] lg:left-[32.5vw] lg:w-[35vw] min-h-[5vh]
            rounded-md px-2 flex items-center bg-dark-primary text-dark-secondary shadow-md border-2 border-dark-active
            transition-all duration-300 ease-linear {{ $translate }}">
    <p id="feedback-text" class="flex-grow text-center">
        {{ $feedback }}
    </p>
    <button id="dismiss-feedback" class="flex items-center justify-end mr-2">
        <i class="fas fa-times fa-sm"></i>
    </button>
</footer>