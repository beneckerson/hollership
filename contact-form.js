// Contact form handling script with AJAX submission

document.addEventListener('DOMContentLoaded', function() {
    const contactForm = document.getElementById('contactForm');
    
    if (contactForm) {
        contactForm.addEventListener('submit', function(e) {
            e.preventDefault();
            
            // Get form values
            const name = document.getElementById('name').value;
            const email = document.getElementById('email').value;
            const subject = document.getElementById('subject').value;
            const message = document.getElementById('message').value;
            
            // Basic validation
            if (!name || !email || !subject || !message) {
                showFormMessage('Please fill in all fields', 'error');
                return;
            }
            
            // Email validation
            if (!isValidEmail(email)) {
                showFormMessage('Please enter a valid email address', 'error');
                return;
            }
            
            // Show loading state
            const submitButton = contactForm.querySelector('button[type="submit"]');
            const originalButtonText = submitButton.textContent;
            submitButton.textContent = 'Sending...';
            submitButton.disabled = true;
            
            // Create form data for submission
            const formData = new FormData();
            formData.append('name', name);
            formData.append('email', email);
            formData.append('subject', subject);
            formData.append('message', message);
            
            // Send AJAX request
            fetch('process-form.php', {
                method: 'POST',
                body: formData,
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
            .then(response => response.json())
            .then(data => {
                // Reset button
                submitButton.textContent = originalButtonText;
                submitButton.disabled = false;
                
                if (data.success) {
                    // Reset form on success
                    contactForm.reset();
                    
                    // Show success message
                    showFormMessage(data.message, 'success');
                } else {
                    // Show error message
                    let errorMessage = data.message;
                    
                    // Add specific errors if available
                    if (data.errors && data.errors.length > 0) {
                        errorMessage += '<ul>';
                        data.errors.forEach(error => {
                            errorMessage += `<li>${error}</li>`;
                        });
                        errorMessage += '</ul>';
                    }
                    
                    showFormMessage(errorMessage, 'error');
                }
            })
            .catch(error => {
                // Reset button
                submitButton.textContent = originalButtonText;
                submitButton.disabled = false;
                
                // Show error message
                showFormMessage('An error occurred while sending your message. Please try again later.', 'error');
                console.error('Form submission error:', error);
            });
        });
    }
    
    // Helper function to validate email
    function isValidEmail(email) {
        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        return emailRegex.test(email);
    }
    
    // Helper function to show form messages
    function showFormMessage(message, type) {
        // Remove any existing message
        const existingMessage = document.querySelector('.form-message');
        if (existingMessage) {
            existingMessage.remove();
        }
        
        // Create message element
        const messageElement = document.createElement('div');
        messageElement.className = `form-message ${type}`;
        messageElement.innerHTML = message;
        
        // Insert after form
        contactForm.insertAdjacentElement('afterend', messageElement);
        
        // Auto-remove after 5 seconds
        setTimeout(function() {
            messageElement.remove();
        }, 5000);
    }
    
    // Add CSS for form messages
    document.head.insertAdjacentHTML('beforeend', `
        <style>
            .form-message {
                padding: 15px;
                margin-top: 20px;
                border-radius: 4px;
                font-weight: 600;
            }
            
            .form-message.success {
                background-color: #d4edda;
                color: #155724;
                border: 1px solid #c3e6cb;
            }
            
            .form-message.error {
                background-color: #f8d7da;
                color: #721c24;
                border: 1px solid #f5c6cb;
            }
            
            .form-message ul {
                margin-top: 10px;
                margin-bottom: 0;
                padding-left: 20px;
            }
        </style>
    `);
});
