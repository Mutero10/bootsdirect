document.addEventListener('DOMContentLoaded', () => {
    console.log('JavaScript file loaded successfully');


    // Common variables
    const signupForm = document.getElementById('form'); // Form ID for the signup page
    const loginForm = document.getElementById('loginForm');   // Form ID for the login page

    if (signupForm) {
        console.log('Signup form detected.');

      /*  const student_id = document.getElementById('student_id'); */
        const name = document.getElementById('name');
        const password = document.getElementById('password');
        const errorElement = document.getElementById('error');

        signupForm.addEventListener('submit', (e) => {
            let messages = [];

            // Validate Student ID (Exactly 6 numeric characters)
         /*   if (!student_id || student_id.value.trim() === '') {
                messages.push('Student ID is required');
            } else if (!/^\d{6}$/.test(student_id.value)) {
                messages.push('Student ID must be exactly 6 numeric characters');
            }
/*
            /* Validate Name (Cannot be blank)
            if (!name || name.value.trim() === '') {
                messages.push('Name is required');
            } else if (!/^[A-Za-z\s]+$/.test(name.value.trim())) {
                messages.push('Name must contain only alphabetic characters');
            }*/

            // Validate Password (Length must be greater than 6)
            if (password && password.value.length <= 6) {
                messages.push('Password must be longer than 6 characters');
            }

            // Display Error Messages
            if (messages.length > 0) {
                e.preventDefault();
                if (errorElement) {
                    errorElement.innerText = messages.join(', ');
                } else {
                    console.error('Error element not found.');
                }
            }
        });
    }

    if (loginForm) {
        console.log('Login form detected.');

      /*  const student_id = document.getElementById('student_id'); */
        const password = document.getElementById('password');
        const errorElement = document.getElementById('error');

        loginForm.addEventListener('submit', (e) => {
            let messages = [];

            // Validate Student ID (Exactly 6 numeric characters)
         /*   if (!student_id || student_id.value.trim() === '') {
                messages.push('Student ID is required');
            } else if (!/^\d{6}$/.test(student_id.value)) {
                messages.push('Student ID must be exactly 6 numeric characters');
            }
*/
            // Validate Password (Length must be greater than 6)
            if (!password || password.value.trim() === '') {
                messages.push('Password is required');
            } else if (password.value.length <= 6) {
                messages.push('Password must be longer than 6 characters');
            }

            // Display Error Messages
            if (messages.length > 0) {
                e.preventDefault();
                if (errorElement) {
                    errorElement.innerText = messages.join(', ');
                } else {
                    console.error('Error element not found.');
                }
            }
        });
    }
});
