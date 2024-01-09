document.addEventListener("DOMContentLoaded", function() {
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

    const urlParams = new URLSearchParams( window.location.search);
    let postId = urlParams.get('id');


    fetch(`http://127.0.0.1:8080/api/post?id=${postId}`, {
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
            document.body.innerHTML=data;
            editEvents();
        })
        .catch(error => {
            console.error('Error:', error);
        });

});


function editEvents(){
    document.getElementById('backbtn').addEventListener('click', function (e) {
        e.preventDefault();
        gotoBlog();
    });

    document.getElementById('editbtn').addEventListener('click', function(e) {
        e.preventDefault();

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

        const carrierElement = document.querySelector('.carrier');
        const postId = carrierElement.id;

        const title = document.getElementById('title').value;
        const smallDescription = document.getElementById('small_description').value;
        const fullDescription = document.getElementById('full_description').value;

        const requestData = {
            title: title,
            small_description: smallDescription,
            full_description: fullDescription,
            edit: 'true'
        };


        fetch(`http://127.0.0.1:8080/api/post/${postId}`, {
            method: 'PUT',
            headers: {
                'Content-Type': 'application/json',
                'Authorization': `Bearer ${token}`
            },
            body: JSON.stringify(requestData)
        })
            .then(response => {
                if (response.ok) {
                    return response.text();
                } else {
                    throw new Error('Failed to update post');
                }
            })
            .then(data => {
                console.log('Response from API:', data);
                gotoBlog();
            })
            .catch(error => {
                console.error('Error:', error);
            });

    });

}

function gotoBlog() {
    window.location.href="http://127.0.0.1:8080/blogs";
}