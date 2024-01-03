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

window.addEventListener('load', function() {
    loadSelectedTags();
});
document.addEventListener("DOMContentLoaded", function() {

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

    document.getElementById('addPostbtn').addEventListener('click', function (e) {
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

        fetch('http://127.0.0.1:8080/api/post', {
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



    document.getElementById('draftPostbtn').addEventListener('click', function (e) {
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