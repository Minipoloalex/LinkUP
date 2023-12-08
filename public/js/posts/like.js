import { getCsrfToken } from '../ajax.js';

// Function to initialize the like button state based on whether the user has liked the post
export async function initializeLikeButton(postId, likeButton) {
    if(isAuthenticated === true){
        try {
            const alreadyLiked = await checkLikedStatus(postId);
            likeButton.setAttribute('data-liked', alreadyLiked);
            if(alreadyLiked === true){
                likeButton.style.color = "red";
            }
            if(alreadyLiked === false){
                likeButton.style.color = "black";
            }

        } catch (error) {
            console.error('Error initializing like button:', error.message);
        }
    }
    else 
        likeButton.style.color = "black";
}


// Event delegation for handling post likes or unlikes
document.addEventListener('click', async function (e) {
    if (e.target && e.target.matches('.like-button')) {
        e.preventDefault();
        const likeButton = e.target;
        const postId = likeButton.getAttribute('data-id');
        const likesCount = likeButton.parentElement.querySelector('.likes');
        let alreadyLiked = likeButton.getAttribute('data-liked') === 'true';

        try {
            let response;
            if (!alreadyLiked) {
                response = await likeOrUnlikePost(postId, true); // Like the post
                if(isAuthenticated === true)
                    likeButton.style.color = "red";
            } else {
                response = await likeOrUnlikePost(postId, false); // Unlike the post
                likeButton.style.color = "black";
            }

            if ('likesCount' in response && 'alreadyLiked' in response) {
                const updatedLikesCount = response.likesCount;
                likesCount.textContent = updatedLikesCount;

                alreadyLiked = response.alreadyLiked;
                likeButton.setAttribute('data-liked', alreadyLiked);
            }
        } catch (error) {
            
        }
    }
});

// Call initializeLikeButton when the page loads or when the post section is rendered
document.addEventListener('DOMContentLoaded', async () => {
    const posts = document.querySelectorAll('.post');

    for (const post of posts) {
        const postId = post.getAttribute('data-id');
        const likeButton = post.querySelector('.like-button');

        await initializeLikeButton(postId, likeButton);

        // Find like buttons for comments and initialize them
        const commentLikeButtons = post.querySelectorAll('.comment .like-button');
        commentLikeButtons.forEach(async (commentLikeButton) => {
            const commentId = commentLikeButton.getAttribute('data-id');
            await initializeLikeButton(commentId, commentLikeButton);
        });
    }
});

// Function to check the like status of the post
async function checkLikedStatus(postId) {
    try {
        const response = await fetch(`/post/${postId}/like`, {
            method: 'GET',
            headers: {
                'Content-Type': 'application/json',
            },
        });

        if (!response.ok) {
            throw new Error('Failed to fetch liked status');
        }

        const data = await response.json();
        return data.alreadyLiked; 
    } catch (error) {
        console.error('Error checking liked status:', error.message);
        throw new Error('Failed to fetch liked status');
    }
}


// Function to handle liking or unliking a post asynchronously
async function likeOrUnlikePost(postId, like) {
    if (!isAuthenticated) {
        // Display a message or redirect the user to the login page
        return;
    }
    else{
        if(like === true){
            try {
                const response = await fetch(`/post/${postId}/like`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': getCsrfToken(),
                    },
                    body: JSON.stringify({
                        like,
                    }),
                });

                const responseData = await response.json();

                if (!response.ok) {
                    throw new Error('Unable to perform action on the post');
                }

                return { likesCount: responseData.likesCount, alreadyLiked: responseData.alreadyLiked };
            } catch (error) {
                console.error('Error performing action on post:', error.message);
                throw new Error('Unable to perform action on the post');
            }
        }
        if(like === false){

            try {
                const response = await fetch(`/post/${postId}/like`, {
                    method: 'DELETE',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': getCsrfToken(),
                    },
                    body: JSON.stringify({
                        like,
                    }),
                });

                const responseData = await response.json();

                if (!response.ok) {
                    throw new Error('Unable to perform action on the post');
                }

                return { likesCount: responseData.likesCount, alreadyLiked: responseData.alreadyLiked };
            } catch (error) {
                console.error('Error performing action on post:', error.message);
                throw new Error('Unable to perform action on the post');
            }
        }
    }
}
