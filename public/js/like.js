// Function to handle liking or unliking a post asynchronously
async function likeOrUnlikePost(postId, like) {
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
      console.log('Response data: ', responseData);
  
      if (!response.ok) {
        throw new Error('Unable to perform action on the post');
      }
  
      return { likesCount: responseData.likesCount, alreadyLiked: responseData.alreadyLiked };
    } catch (error) {
      console.error('Error performing action on post:', error.message);
      throw new Error('Unable to perform action on the post');
    }
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
        } else {
          response = await likeOrUnlikePost(postId, false); // Unlike the post
        }
  
        if ('likesCount' in response && 'alreadyLiked' in response) {
          const updatedLikesCount = response.likesCount;
          likesCount.textContent = updatedLikesCount;
  
          alreadyLiked = response.alreadyLiked;
          likeButton.setAttribute('data-liked', alreadyLiked);
          
          // Change the button text or appearance based on the current action
          likeButton.textContent = alreadyLiked ? 'Unlike' : 'Like';
          
          console.log('Post action performed successfully');
        }
      } catch (error) {
        console.error('Error performing action on post:', error.message);
        // Handle error, show error message, etc.
      }
    }
  });
  