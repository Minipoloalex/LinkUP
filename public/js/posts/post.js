const content = document.getElementById('content');

// unhide parent post if it exists  
function restoreAndSkipToParentPost() {
    const parentPost = document.getElementById('parent-post');

    if (parentPost) {
        parentPost.classList.remove('hidden');
        content.scrollTo(0, parentPost.offsetHeight);
    }
}

// when scrolling up, hide the arrow, otherwise show it
content.addEventListener('scroll', () => {
    const arrowUp = document.getElementById('arrow-up');
    
    if (!arrowUp) return;

    if (content.scrollTop > 0) {
        arrowUp.classList.remove('hidden');
    } else {
        arrowUp.classList.add('hidden');
    }
});

restoreAndSkipToParentPost();