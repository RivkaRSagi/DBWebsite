// Get the login form
const loginForm = document.getElementById('loginForm');

// Add a submit event listener to the form
loginForm.addEventListener('submit', (event) => {
    event.preventDefault(); // Stop the form from reloading the page

    // Get the selected role from the dropdown
    const role = document.getElementById('role').value;

    // Redirect to the appropriate form page based on the role
    if (role === 'student') {
        window.location.href = 'student_form.html';
    } else if (role === 'librarian') {
        window.location.href = 'librarian_form.html';
    } else if (role === 'retail') {
        window.location.href = 'retail_form.html';
    } else {
        alert('Invalid role'); // Alert the user if the role is invalid
    }
});
