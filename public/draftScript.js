
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

    fetch('http://127.0.0.1:8080/api/draft', {
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
                throw new Error('Failed to fetch draft');
            }
        })
        .then(data => {
            if(data){
                document.body.innerHTML=data;
               draftEvents();
            }
            else{
                console.log("no Draft");
            }
        })
        .catch(error => {
            console.error('Error:', error);
        });
});

function draftEvents(){
    document.getElementById('submitbtn').addEventListener('click', function (e) {
        e.preventDefault();
        const title = document.getElementById("title").value;
        const smallDescription = document.getElementById("small_description").value;
        const fullDescription = document.getElementById("full_description").value;
        // const image = document.getElementById("imageInput").value;


        const cookies = document.cookie.split(';').reduce((cookiesObject, cookie) => {
            const [key, value] = cookie.trim().split('=');
            cookiesObject[key] = value;
            return cookiesObject;
        }, {});

        const token = cookies.token;

        if (!token) {
            console.error('Token not found in local storage');
            return;
        }

        const requestData = {
            token: token,
            title: title,
            small_description: smallDescription,
            full_description: fullDescription,
            image: "postimage.png",
            tags: getCheckedTagIDs()
        };

        fetch('http://127.0.0.1:8080/api/draft', {
            method: 'PUT',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify(requestData)
        })
            .then(response => {
                if (response.ok) {
                    return response.text();
                } else {
                    throw new Error('Failed to submit data');
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





    document.getElementById('backbtn').addEventListener('click', function (e) {
        e.preventDefault();
        gotoBlog();
    });

}



function gotoBlog() {
    window.location.href='http://127.0.0.1:8080/blogs';
}

function getCheckedTagIDs() {
    const checkedTagIDs = [];
    const checkboxes = document.querySelectorAll('input[name="tags[]"]:checked');
    checkboxes.forEach(checkbox => {
        const tagID = parseInt(checkbox.value);
        checkedTagIDs.push(tagID);
    });
    return checkedTagIDs;
}
