@php
$headerText = $group !== null ? "Add a new post in group $group->name"
                                : 'Create a new post';
@endphp
@auth
    <div id="create-post"
        class="hidden fixed top-0 left-0 w-screen h-screen bg-transparent z-40 lg:px-[10vw] xl:px-[30vw] pointer-events-none">
        <div class="h-[6rem] w-full filler"></div>
        @include('partials.create_post_form', [
        'formClass' => 'add-post',
        'zValue' => 40,
        'textPlaceholder' => 'Add a new post', 'buttonText' => 'Post', 'contentValue' => '', 'headerText' => $headerText])
    </div>
    <div id="dark-overlay" class="hidden fixed top-0 left-0 w-full h-full bg-black opacity-40 z-[35]"></div>
@endauth