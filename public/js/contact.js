function submitForm() {
    const form = document.getElementById('contactFormElement');
    const contactForm = document.getElementById('contactForm');
  
    if (form.checkValidity()) {
        // Hide the form and display the thank you message
        form.style.display = 'none';
        const thankYouMessage = document.createElement('p');
        thankYouMessage.textContent = 'Thank you, your message was submitted';
        thankYouMessage.style.fontSize = '1.2rem';
        contactForm.appendChild(thankYouMessage);
    
        // Reset the form after 3 seconds and show it again
        setTimeout(function() {
        contactForm.removeChild(thankYouMessage);
        form.style.display = 'block';
        form.reset();
        }, 3000);

    } else {
        // Form is invalid, display error messages or handle accordingly
        // You can add error messages or perform actions for invalid fields
        console.log('Form is invalid!');
    }
  }
  
  function cancelForm() {
    const form = document.getElementById('contactFormElement');
    form.reset();
    form.style.display = 'block';
  
    // Reload the page
    window.location.reload();
  }

  


  
/* make the message field automatically grow as the user types */
let messageInput = document.getElementById('message');

messageInput.addEventListener('input', function () {
    this.style.height = 'auto'; // Reset the height to auto to ensure the correct height calculation
    this.style.height = (this.scrollHeight) + 'px'; // Set the height based on content
});


