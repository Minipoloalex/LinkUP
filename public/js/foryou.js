// Assuming you are using Fetch API for AJAX requests
async function fetchForYouPosts() {
  try {
      const response = await fetch('/foryou'); // Endpoint that fetches forYouPosts
      console.log(response);
      if (!response.ok) {
          throw new Error('Failed to fetch for you posts');
      }
      const data = await response.json();

      // Assuming data.posts contains the fetched posts



      const forYouArraysOfPosts = data.posts;
      const forYouPosts = [];

      // iterate through each array of posts and add the posts to the forYouPosts array
      for (const arrayOfPosts of forYouArraysOfPosts) {
          for (const post of arrayOfPosts) {
              forYouPosts.push(post);
          }
      }

      console.log(forYouPosts);

      // Reference to the for-you-timeline div
      const forYouTimeline = document.getElementById('for-you-timeline');

      // Render each post in forYouPosts
      for (const post of forYouPosts) {
        



          const postElement = document.createElement('div');
          postElement.classList.add('post');
          // Customize how each post should be displayed
          postElement.innerHTML = `<p>${post.content}</p>`; // Adjust based on your post structure
          console.log(post.content);
          forYouTimeline.appendChild(postElement);
      }
  } catch (error) {
      console.error('Error fetching for you posts:', error.message);
      // Handle the error accordingly
  }
}

// Invoke the fetchForYouPosts function when the window loads
window.onload = () => {
  fetchForYouPosts();
};


