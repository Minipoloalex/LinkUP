// Event delegation for the like button inside the #timeline container
document.querySelector('#timeline').addEventListener('click', async function(e) {
  console.log(e.target);
  if (e.target && e.target.matches('.like-button')) {
      e.preventDefault();

      const postId = e.target.getAttribute('data-id');
      const likeButton = e.target; // Cache the like button element
      console.log(likeButton);

      console.log(postId);
      try {

          const response = await likePost(postId); // Call the function to like the post

          // Update the likes count on success
          const updatedLikesCount = response.likesCount; // Assuming the response contains the updated likes count
          const likesCount = likeButton.parentElement.querySelector('.likes');
          likesCount.textContent = updatedLikesCount;

          console.log('Post liked successfully');
          console.log(likesCount.textContent);
      } catch (error) {
          console.error('Error liking post:', error.message);
          // Handle error condition
      }
  }
});


// Add an event listener to the like button
document.addEventListener('DOMContentLoaded', function() {
  const likeButton = document.querySelector('.like-button');
  if (likeButton) {
      likeButton.addEventListener('click', function(e) {
        e.preventDefault();

        const postId = this.getAttribute('data-id');
        const likeButton = this; // Cache the like button element
        const likesCount = document.querySelector('.likes'); // Select the element displaying the like count
        console.log(likesCount.textContent);
      
        likePost(postId)
            .then(response => {
                console.log(response);
                // Update the likes count on success
                const updatedLikesCount = response.likesCount; // Assuming the response contains the updated likes count
                likesCount.textContent = updatedLikesCount; // Update the like count in the DOM
                console.log('Post liked successfully');
                console.log(likesCount.textContent);
            })
            .catch(error => {
                console.error('Error liking post:', error.message);
                // Handle error condition
            });
      });
  }
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
