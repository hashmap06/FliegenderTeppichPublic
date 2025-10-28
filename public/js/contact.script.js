/*
document.addEventListener('DOMContentLoaded', function() {
    // Function to display error messages
    function showError(input, message) {
        const errorElement = document.createElement('div');
        errorElement.className = 'error-message';
        errorElement.innerText = message;
        // Insert error message after the input element
        input.parentNode.insertBefore(errorElement, input.nextSibling);
        input.classList.add('error');
    }

    // Function to remove error messages
    function removeError(input) {
        const errorElement = input.nextElementSibling;
        if (errorElement && errorElement.classList.contains('error-message')) {
            errorElement.parentNode.removeChild(errorElement);
            input.classList.remove('error');
        }
    }

    function testShowError() {
        const inputToTest = document.getElementById('fname'); // Replace 'fname' with the actual id of the input you want to test
        inputToTest.style.marginBottom = '5px';
        showError(inputToTest, 'This field is required.'); // Example error message
    }

    // Call the test function to simulate showing an error
    //testShowError();

    // Function to validate form fields
    function validateForm() {
        let isValid = true;

        // Reset previous errors
        const errorElements = document.querySelectorAll('.error-message');
        errorElements.forEach(el => el.parentNode.removeChild(el));
        const errorInputs = document.querySelectorAll('.error');
        errorInputs.forEach(el => el.classList.remove('error'));

        // Validate name field
        const nameInput = document.getElementById('fname');
        if (!nameInput.value.trim()) {
            showError(nameInput, 'Bitte geben Sie Ihren Namen ein.');
            isValid = false;
        }

        // Validate email field if present
        const emailInput = document.getElementById('lname');
        if (emailInput && !emailInput.value.trim()) {
            showError(emailInput, 'Bitte geben Sie Ihre E-Mail-Adresse ein.');
            isValid = false;
        }

        // Validate message box
        const messageInput = document.getElementById('subject');
        if (!messageInput.value.trim()) {
            showError(messageInput, 'Bitte geben Sie eine Nachricht ein.');
            isValid = false;
        }

        return isValid;
    }

    // Submit event listener for the form
    const forms = document.querySelectorAll('form');
    forms.forEach(form => {
        form.addEventListener('submit', function(event) {
            // Validate form on submit
            if (!validateForm()) {
                event.preventDefault(); // Prevent form submission if validation fails
            }
        });
    });

    // Event listeners to remove errors on input change
    const inputs = document.querySelectorAll('input, textarea');
    inputs.forEach(input => {
        input.addEventListener('input', function() {
            removeError(input);
        });
    });
});

*/