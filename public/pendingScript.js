document.getElementById('backbtn').addEventListener('click', function (e) {
    e.preventDefault();
    gotoBlog();
});

const postElements = document.querySelectorAll('.read');

postElements.forEach(postElement => {
    postElement.addEventListener('click', function(e) {
        e.preventDefault();
        const postId = this.getAttribute('id');

        const cookies = document.cookie.split(';').reduce((cookiesObject, cookie) => {
            const [key, value] = cookie.trim().split('=');
            cookiesObject[key] = value;
            return cookiesObject;
        }, {});

        const token = cookies.token;
        fetch(`http://127.0.0.1:8080/api/post/${postId}`, {
            method: 'GET',
            headers: {
                'Content-Type': 'application/json',
                'Authorization': `Bearer ${token}`
            }
        })
            .then(response => {
                if (response.ok) {
                    return response.text();
                } else {
                    throw new Error('Failed to fetch post data');
                }
            })
            .then(data => {
                window.close();
                const newTab = window.open();
                newTab.document.open();
                newTab.document.write(data);
                newTab.document.close();
            })
            .catch(error => {
                console.error('Error:', error);
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
            window.close();
            const newTab = window.open();
            newTab.document.open();
            newTab.document.write(data);
            newTab.document.close();
        })
        .catch(error => {
            console.error('Error:', error);
        });
}