document.getElementById('backbtn').addEventListener('click', function (e) {
    e.preventDefault();
    gotoBlog();
});

document.getElementById('editbtn').addEventListener('click', function (e) {
    e.preventDefault();
    const cookies = document.cookie.split(';').reduce((cookiesObject, cookie) => {
        const [key, value] = cookie.trim().split('=');
        cookiesObject[key] = value;
        return cookiesObject;
    }, {});

    const token = cookies.token;

    const h1Element = document.querySelector('.h1');
    const postId = h1Element.getAttribute('id');

    if (!token) {
        console.error('Token not found in cookies');
        return;
    }

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


document.getElementById('Modelcommentbtn').addEventListener('click', function(e) {
    e.preventDefault();
    const commentValue = document.getElementById('comment').value;
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

    const h1Element = document.querySelector('.h1');
    const postId = h1Element.getAttribute('id');



    const requestData = {
        comment: commentValue
    };

    fetch(`http://127.0.0.1:8080/api/post/${postId}/comment`, {
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
                throw new Error('Failed to post comment');
            }
        })
        .then(data => {
            console.log('Response from API:', data);
            gotoread(postId);
        })
        .catch(error => {
            console.error('Error:', error);
        });
});

let myApproveModal = new bootstrap.Modal(document.getElementById('approveModal'), {
    keyboard: false
});

document.getElementById('approveModelCancelbtn').addEventListener('click', function (e) {
    myApproveModal.hide();
});
document.getElementById('approveModelClosebtn').addEventListener('click', function (e) {
    myApproveModal.hide();
});

document.getElementById('approvebtn').addEventListener('click', function (e) {
    e.preventDefault();
    myApproveModal.show();

});







document.getElementById('ModelApprovebtn').addEventListener('click', function(e) {
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

    const h1Element = document.querySelector('h1');
    const postId = h1Element.getAttribute('id');

    const requestData = {
        approve: true
    };

    fetch(`http://127.0.0.1:8080/api/post/${postId}`, {
        method: 'PATCH',
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
            console.log('Successfully approved');
            gotoBlog();

        })
        .catch(error => {
            console.error('Error:', error);
        });
});




let myModal = new bootstrap.Modal(document.getElementById('deleteModal'), {
    keyboard: false
});

document.getElementById('modelDeletebtn').addEventListener('click', function (e) {
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

    const h1Element = document.querySelector('h1');
    const postId = h1Element.getAttribute('id');

    const requestData = {
        approve: true
    };

    fetch(`http://127.0.0.1:8080/api/post/${postId}`, {
        method: 'DELETE',
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
            console.log('Deleted Successfully');
            gotoBlog();

        })
        .catch(error => {
            console.error('Error:', error);
        });

});
document.getElementById('modelCancelbtn').addEventListener('click', function (e) {
    myModal.hide();
});
document.getElementById('modelClosebtn').addEventListener('click', function (e) {
    myModal.hide();
});

document.getElementById('deletebtn').addEventListener('click', function (e) {
    e.preventDefault();
    myModal.show();

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
function gotoread(postId){
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
}



let myCommentModal = new bootstrap.Modal(document.getElementById('commentModal'), {
    keyboard: false
});

document.getElementById('commentModelCancelbtn').addEventListener('click', function (e) {
    myCommentModal.hide();
});
document.getElementById('commentModelClosebtn').addEventListener('click', function (e) {
    myCommentModal.hide();
});

document.getElementById('commentbtn').addEventListener('click', function (e) {
    e.preventDefault();
    myCommentModal.show();

});
