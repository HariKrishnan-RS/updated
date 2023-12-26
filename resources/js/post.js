fetch("http://localhost:8000/api/posts")
    .then((response) => response.json())
    .then((posts) => {
        const postsContainer = document.getElementById("card-pack");

        posts.forEach((post) => {
            const card = document.createElement("div");
            card.classList.add("card", "col-md-4", "mb-4");

            const cardImg = document.createElement("img");
            cardImg.classList.add("card-img-top");
            cardImg.src = "images/post-img.jpg"; // Replace with your image source
            cardImg.alt = "Placeholder Image";

            const cardBody = document.createElement("div");
            cardBody.classList.add("card-body");

            const title = document.createElement("h5");
            title.classList.add("card-title");
            title.textContent = post.title;

            const smallDescription = document.createElement("p");
            smallDescription.classList.add("card-text");
            smallDescription.textContent = post.small_description;

            const readButton = document.createElement("a");
            readButton.classList.add("btn", "btn-primary");
            readButton.href = "blogPage/read/" + post.id;
            readButton.textContent = "Read";

            // Append elements to the card
            card.appendChild(cardImg);
            cardBody.appendChild(title);
            cardBody.appendChild(smallDescription);
            cardBody.appendChild(readButton);
            card.appendChild(cardBody);

            // Append the card to the container
            postsContainer.appendChild(card);
        });
    })
    .catch((error) => {
        console.error("Error fetching posts:", error);
    });
