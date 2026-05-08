// ===================================
// URAIA - Formulaire de Contact
// ===================================

document.addEventListener('DOMContentLoaded', function() {
    
    const contactForm = document.getElementById('contact-form');
    
    if (contactForm) {
        contactForm.addEventListener('submit', function(e) {
            e.preventDefault();
            
            // Get form data
            const formData = new FormData(this);
            const submitBtn = this.querySelector('button[type="submit"]');
            const originalBtnText = submitBtn.innerHTML;
            
            // Validate form
            if (!validateContactForm(this)) {
                return false;
            }
            
            // Disable button and show loading
            submitBtn.disabled = true;
            submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> ' + t('loading');
            
            // Send AJAX request
            fetch('contact.php', {
                method: 'POST',
                body: formData,
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    showFlashMessage('success', data.message || t('form_success'));
                    contactForm.reset();
                } else {
                    showFlashMessage('error', data.message || t('form_error'));
                }
            })
            .catch(error => {
                console.error('Error:', error);
                showFlashMessage('error', t('form_error'));
            })
            .finally(() => {
                // Re-enable button
                submitBtn.disabled = false;
                submitBtn.innerHTML = originalBtnText;
            });
        });
    }
    
    // Form validation
    function validateContactForm(form) {
        let isValid = true;
        
        // Name validation
        const nameField = form.querySelector('[name="nom"]');
        if (nameField && !nameField.value.trim()) {
            isValid = false;
            showError(nameField, t('required_field'));
        } else if (nameField) {
            clearError(nameField);
        }
        
        // Email validation
        const emailField = form.querySelector('[name="email"]');
        if (emailField) {
            if (!emailField.value.trim()) {
                isValid = false;
                showError(emailField, t('required_field'));
            } else if (!isValidEmail(emailField.value)) {
                isValid = false;
                showError(emailField, t('email_invalid'));
            } else {
                clearError(emailField);
            }
        }
        
        // Subject validation
        const subjectField = form.querySelector('[name="objet"]');
        if (subjectField && !subjectField.value.trim()) {
            isValid = false;
            showError(subjectField, t('required_field'));
        } else if (subjectField) {
            clearError(subjectField);
        }
        
        // Message validation
        const messageField = form.querySelector('[name="description"]');
        if (messageField && !messageField.value.trim()) {
            isValid = false;
            showError(messageField, t('required_field'));
        } else if (messageField) {
            clearError(messageField);
        }
        
        return isValid;
    }
    
    // Show error message
    function showError(field, message) {
        field.style.borderColor = '#e74c3c';
        field.classList.add('error');
        
        // Remove existing error message
        const existingError = field.parentNode.querySelector('.error-message');
        if (existingError) {
            existingError.remove();
        }
        
        // Create error message element
        const errorElement = document.createElement('span');
        errorElement.className = 'error-message';
        errorElement.style.color = '#e74c3c';
        errorElement.style.fontSize = '0.85rem';
        errorElement.style.marginTop = '0.25rem';
        errorElement.style.display = 'block';
        errorElement.textContent = message;
        
        field.parentNode.appendChild(errorElement);
    }
    
    // Clear error message
    function clearError(field) {
        field.style.borderColor = '';
        field.classList.remove('error');
        
        const errorElement = field.parentNode.querySelector('.error-message');
        if (errorElement) {
            errorElement.remove();
        }
    }
    
    // Email validation regex
    function isValidEmail(email) {
        const re = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        return re.test(email);
    }
    
    // Show flash message
    function showFlashMessage(type, message) {
        // Remove existing flash messages
        const existingFlash = document.querySelectorAll('.flash-message');
        existingFlash.forEach(flash => flash.remove());
        
        // Create flash message element
        const flashElement = document.createElement('div');
        flashElement.className = `flash-message flash-${type}`;
        flashElement.innerHTML = `
            <i class="fas fa-${type === 'success' ? 'check-circle' : 'exclamation-circle'}"></i>
            ${message}
            <button class="close-flash"><i class="fas fa-times"></i></button>
        `;
        flashElement.style.cssText = `
            position: fixed;
            top: 100px;
            right: 20px;
            z-index: 9999;
            min-width: 300px;
            max-width: 500px;
            padding: 1rem;
            border-radius: 8px;
            display: flex;
            align-items: center;
            gap: 0.5rem;
            animation: slideIn 0.3s ease;
        `;
        
        // Add to page
        document.body.appendChild(flashElement);
        
        // Auto-close after 5 seconds
        setTimeout(() => {
            flashElement.style.opacity = '0';
            flashElement.style.transform = 'translateX(100%)';
            setTimeout(() => flashElement.remove(), 300);
        }, 5000);
        
        // Close button functionality
        const closeBtn = flashElement.querySelector('.close-flash');
        closeBtn.addEventListener('click', function() {
            flashElement.style.opacity = '0';
            flashElement.style.transform = 'translateX(100%)';
            setTimeout(() => flashElement.remove(), 300);
        });
    }
    
    // Add CSS animation for flash messages
    const style = document.createElement('style');
    style.textContent = `
        @keyframes slideIn {
            from {
                opacity: 0;
                transform: translateX(100%);
            }
            to {
                opacity: 1;
                transform: translateX(0);
            }
        }
    `;
    document.head.appendChild(style);
    
    // Real-time validation on input
    const formInputs = contactForm ? contactForm.querySelectorAll('input, textarea') : [];
    formInputs.forEach(input => {
        input.addEventListener('blur', function() {
            if (contactForm) {
                validateContactForm(contactForm);
            }
        });
        
        input.addEventListener('input', function() {
            if (this.classList.contains('error')) {
                clearError(this);
            }
        });
    });
    
    // Character counter for textarea
    const messageTextarea = document.querySelector('textarea[name="description"]');
    if (messageTextarea) {
        const counter = document.createElement('span');
        counter.id = 'char-counter';
        counter.style.cssText = `
            float: right;
            font-size: 0.85rem;
            color: #7f8c8d;
        `;
        
        messageTextarea.parentNode.appendChild(counter);
        
        messageTextarea.addEventListener('input', function() {
            const maxLength = this.getAttribute('maxlength') || 1000;
            const currentLength = this.value.length;
            counter.textContent = `${currentLength}/${maxLength}`;
            
            if (currentLength > maxLength * 0.9) {
                counter.style.color = '#e74c3c';
            } else {
                counter.style.color = '#7f8c8d';
            }
        });
        
        // Initialize counter
        const maxLength = messageTextarea.getAttribute('maxlength') || 1000;
        counter.textContent = `${messageTextarea.value.length}/${maxLength}`;
    }
    
});
