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
document.getElementById('searchButton').addEventListener('click', function() {
    saveSelectedTags();
});

