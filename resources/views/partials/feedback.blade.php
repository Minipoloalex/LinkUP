@php
$feedback = session('feedback');
$hidden = isset($feedback);
$translate = $hidden ? 'feedback-active' : '';
@endphp
<footer id="feedback-message" class="z-50 fixed -bottom-12 left-[10vw] w-[80vw] lg:left-[32.5vw] lg:w-[35vw] min-h-[5vh]
            rounded-md px-2 flex items-center dark:bg-dark-active dark:text-dark-secondary
            transition-all duration-300 ease-linear {{ $translate }}">
    <p id="feedback-text">
        {{ $feedback }}
    </p>
    <button id="dismiss-feedback" class="flex flex-grow items-center justify-end">
        <i class="fas fa-times fa-sm"></i>
    </button>
</footer>