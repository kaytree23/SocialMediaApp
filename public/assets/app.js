// app.js
document.getElementById('login-form').addEventListener('submit', function(e) {
    e.preventDefault();

    // Capture the email and password from the form
    const email = document.getElementById('email').value;
    const password = document.getElementById('password').value;

    // Send a POST request to your backend (for now, mock this part)
    console.log('Login attempt:', { email, password });

    // Here you would send the data to the backend API
    // Example with fetch:
    /*
    fetch('http://localhost:8080/api/login', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify({ email, password })
    })
    .then(response => response.json())
    .then(data => console.log('Logged in:', data))
    .catch(error => console.error('Error:', error));
    */
});
