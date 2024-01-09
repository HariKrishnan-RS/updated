// fetch("http://localhost:8080/api/posts")
//     .then((response) => response.json())
//     .then((posts) => {
//         const postsContainer = document.getElementById("card-pack");
//
//         posts.forEach((post) => {
//             const card = document.createElement("div");
//             card.classList.add("card");
//
//             const cardImg = document.createElement("img");
//             cardImg.classList.add("card-img");
//             cardImg.classList.add("card-img-top");
//             cardImg.src = "images/post-img.jpg"; // Replace with your image source
//             cardImg.alt = "Placeholder Image";
//
//             const cardBody = document.createElement("div");
//             cardBody.classList.add("card-body");
//
//             const title = document.createElement("h5");
//             title.classList.add("card-title");
//             title.textContent = post.title;
//
//             const smallDescription = document.createElement("p");
//             smallDescription.classList.add("card-text");
//             smallDescription.textContent = post.small_description;
//
//             const readButton = document.createElement("a");
//             readButton.classList.add("btn", "btn-primary");
//             readButton.href = "blog/read/" + post.id;
//             readButton.textContent = "Read";
//
//             // Append elements to the card
//             card.appendChild(cardImg);
//             cardBody.appendChild(title);
//             cardBody.appendChild(smallDescription);
//             cardBody.appendChild(readButton);
//             card.appendChild(cardBody);
//
//             // Append the card to the container
//             if (post.approved) {
//                 postsContainer.appendChild(card);
//             }
//         });
//     })
//     .catch((error) => {
//         console.error("Error fetching posts:", error);
//     });
// Function to save selected tag IDs to local storage



function saveSelectedTags() {
    const checkboxes = document.querySelectorAll('.btn-check');
    const selectedTags = [];
    checkboxes.forEach(function(checkbox) {
        if (checkbox.checked) {
            selectedTags.push(checkbox.value);
        }
    });
    localStorage.setItem('selectedTags', JSON.stringify(selectedTags));
}

function loadSelectedTags() {
    const selectedTags = JSON.parse(localStorage.getItem('selectedTags'));
    if (selectedTags) {
        selectedTags.forEach(function(tagId) {
            const checkbox = document.getElementById(`tag_${tagId}`);
            if (checkbox) {
                checkbox.checked = true;
            }
        });
    }
}


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
            document.body.innerHTML=data;
            addEvents();
        })
        .catch(error => {
            console.error('Error:', error);
        });

});

function gotologin(){
    window.location.href = 'http://127.0.0.1:8080/login';
}
window.addEventListener('load', function() {
    loadSelectedTags();
});
function addEvents(){


    document.getElementById('searchButton').addEventListener('click', function (e) {
        saveSelectedTags();
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

        const requestData = {
            token: token,
            searchbox:  document.getElementById("searchForm").value,
            "tags": JSON.parse(localStorage.getItem("selectedTags"))
        };

        const queryParams = new URLSearchParams(requestData).toString();

        const apiUrl = `http://127.0.0.1:8080/api/blogs?${queryParams}`;

        fetch(apiUrl, {
            method: 'GET',
            headers: {
                'Content-Type': 'application/json'
            },

        })
            .then(response => {
                if (response.ok) {

                    return response.text();
                } else {
                    throw new Error('Failed to fetch blogs');
                }
            })
            .then(data => {
                const tempElement = document.createElement('div');
                tempElement.innerHTML = data;
                const cardPackContent = tempElement.querySelector('#card-pack').innerHTML;
                document.querySelector('#card-pack').innerHTML=cardPackContent;
            })
            .catch(error => {
                console.error('Error:', error);

            });


    });

    document.getElementById('addPostbtn').addEventListener('click', function (e) {
        e.preventDefault();
        window.location.href='http://127.0.0.1:8080/blogs/post';
    });



    document.getElementById('draftPostbtn').addEventListener('click', function (e) {
        e.preventDefault();
        window.location.href="http://127.0.0.1:8080/draft";


    });


    let myModal = new bootstrap.Modal(document.getElementById('logoutModal'), {
        keyboard: false
    });

    document.getElementById('modelLogoutbtn').addEventListener('click', function (e) {
        e.preventDefault();
        document.cookie = 'token=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/;';
        gotologin();
    });
    document.getElementById('modelCancelbtn').addEventListener('click', function (e) {
        myModal.hide();
    });
    document.getElementById('modelClosebtn').addEventListener('click', function (e) {
        myModal.hide();
    });


    document.getElementById('logoutbtn').addEventListener('click', function (e) {
        e.preventDefault();
        myModal.show();
    });

    const postElements = document.querySelectorAll('.posts');

    postElements.forEach(postElement => {
        postElement.addEventListener('click', function(e) {
            e.preventDefault();
            const postId = this.getAttribute('id');
            window.location.href= `http://127.0.0.1:8080/blog/read?id=${postId}`;

        });
    });




    document.getElementById('pendingbtn').addEventListener('click', function (e) {
        e.preventDefault();
        window.location.href= "http://127.0.0.1:8080/pending";



    });


}