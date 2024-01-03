document.addEventListener("DOMContentLoaded", function() {
    let loginBtn = document.getElementById("loginbtn")
    loginBtn.addEventListener("click", function(e) {
        e.preventDefault();
        var email = document.getElementById("email").value;
        var password = document.getElementById("password").value;

        var data = {
            email: email,
            password: password
        };

        fetch('http://127.0.0.1:8080/api/login', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify(data)
        }).then(response => {
                if (response.ok) {
                    return response.json();
                } else {
                    throw new Error('Failed to login');
                }
            }).then(data => {
                if (data.status === true) {
                    console.log('User logged in successfully');
                    console.log('Token:', data.token);
                    document.cookie = 'token=' + data.token + '; path=/';
                    gotoBlog();
                } else {
                    console.error('Login failed:', data.message);
                    const errorElement = document.getElementById("error");
                    errorElement.style.display = "flex";
                }
            }).catch(error => {
                console.error('Error:', error);
                const errorElement = document.getElementById("error");
                errorElement.style.display = "flex";
            });
    });
});
function gotoBlog() {
    const cookies = document.cookie.split(';').reduce((cookiesObject, cookie) => {
        const [key, value] = cookie.trim().split('=');
        cookiesObject[key] = value;
        return cookiesObject;
    }, {});

    const token = cookies.token;
    if (!token) {
        console.error('Token not found in cookies');
        return;
    }
    fetch('http://127.0.0.1:8080/api/blogs', {
        method: 'GET',
        headers: {
            'Authorization': 'Bearer ' + token
        }
    })
        .then(response => {
            if (response.ok) {
                return response.text();
            } else {
                throw new Error('Failed to fetch blogs');
            }
        })
        .then(data => {
            const newTab = window.open();
            newTab.document.open();
            newTab.document.write(data);
            newTab.document.close();
        })
        .catch(error => {
            console.error('Error:', error);
        });
}