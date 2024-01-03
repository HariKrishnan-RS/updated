function handleRegistration(e) {
    e.preventDefault();
    const name = document.getElementById("name").value;
    const email = document.getElementById("email").value;
    const password = document.getElementById("password").value;
    const confirmPassword = document.getElementById("Password-conform").value;

    if (password !== confirmPassword) {
        console.error("Passwords do not match");
        return;
    }

    fetch('http://127.0.0.1:8080/api/register', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({
            name: name,
            email: email,
            password: password
        })
    })
        .then(response => {
            if (response.ok) {
                console.log('User registered successfully');
            } else {
                throw new Error('Registration failed');
            }
        })
        .catch(error => {
            console.error('Error:', error);
        });
}

document.getElementById("registerBtn").addEventListener("click", handleRegistration);
