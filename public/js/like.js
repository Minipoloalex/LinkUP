// Modify the success callback in the like button click event
$('.like-button').on('click', function(e) {
    e.preventDefault();
  
    const postId = $(this).data('id');
    const likeButton = $(this); // Cache the like button element
  
    likePost(postId)
      .then(response => {
        // Update the likes count on success
        console.log(likeButton);
        const likesCountElement = likeButton.siblings('.likes');
        likesCountElement.text(response.likesCount); // Assuming the response contains the updated likes count
        console.log(response.likesCount);
      })
      .catch(error => {
        console.error('Error liking post:', error.message);
        // Handle error condition
      });
  });

// Function to like a post asynchronously
async function likePost(postId) {
    try {
      const response = await fetch(`/post/${postId}/like`, {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json',
          'X-CSRF-TOKEN': getCsrfToken(), // Assuming you have a function to get CSRF token
        },
        body: JSON.stringify({
          like: true,
        }),
      });
  
      if (!response.ok) {
        throw new Error('Unable to like the post');
      }
  
      const responseData = await response.json();
      return { likesCount: responseData.likesCount }; // Update with the correct property from the backend response
    } catch (error) {
      throw new Error(error.message);
    }
  }
