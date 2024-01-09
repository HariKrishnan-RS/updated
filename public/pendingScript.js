document.addEventListener("DOMContentLoaded", function() {
    const cookies = document.cookie.split(';').reduce((cookiesObject, cookie) => {
        const [key, value] = cookie.trim().split('=');
        cookiesObject[key] = value;
        return cookiesObject;
    }, {});

    const token = cookies.token;

    if (!token) {
        console.error('Token not found in cookies');

        document.title = '404 Error Page';
        document.body.innerHTML = '<h1>404 - Page Not Found</h1><p>The requested page was not found.</p>';
        return;
    }

    fetch(`http://127.0.0.1:8080/api/post?pending`, {
        method: 'GET',
        headers: {
            'Content-Type': 'application/json',
            'Authorization': `Bearer ${token}`
        },
    })
        .then(response => {
            if (response.ok) {
                return response.text();
            } else {
                throw new Error('Failed to update post');
            }
        })
        .then(data => {
     document.body.innerHTML=data;
           pendingEvents();
        })
        .catch(error => {
            console.error('Error:', error);
        });

});



function pendingEvents(){


    document.getElementById('backbtn').addEventListener('click', function (e) {
        e.preventDefault();
        gotoBlog();
    });

    const postElements = document.querySelectorAll('.read');

    postElements.forEach(postElement => {
        postElement.addEventListener('click', function(e) {
            e.preventDefault();
            const postId = this.getAttribute('id');
            window.location.href= `http://127.0.0.1:8080/blog/read?id=${postId}`;

        });
    });



}








function gotoBlog() {
    window.location.href='http://127.0.0.1:8080/blogs';
}