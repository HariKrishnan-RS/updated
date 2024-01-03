



document.getElementById('draftbtn').addEventListener('click', function (e) {
    e.preventDefault();
    const title = document.getElementById("title").value;
    const smallDescription = document.getElementById("small_description").value;
    const fullDescription = document.getElementById("full_description").value;


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
        title: title,
        small_description: smallDescription,
        full_description: fullDescription,
        draft:"true"
    };

    fetch('http://127.0.0.1:8080/api/draft', {
        method: 'POST',
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

    fetch('http://127.0.0.1:8080/api/post', {
        method: 'POST',
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
function getCheckedTagIDs() {
    const checkedTagIDs = [];
    const checkboxes = document.querySelectorAll('input[name="tags[]"]:checked');
    checkboxes.forEach(checkbox => {
        const tagID = parseInt(checkbox.value);
        checkedTagIDs.push(tagID);
    });
    return checkedTagIDs;
}



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
