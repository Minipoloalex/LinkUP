function submitForm() {
    const form = document.getElementById('contactFormElement');
    const contactForm = document.getElementById('contactForm');
  
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
  }
  
  function cancelForm() {
    const form = document.getElementById('contactFormElement');
    form.reset();
    form.style.display = 'block';
  
    // Reload the page
    window.location.reload();
  }
  