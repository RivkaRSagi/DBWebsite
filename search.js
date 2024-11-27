//main function that integrates the Google search API with the website
function searchBooks() {
    //gets query value from the search bar in library page
    const query = document.getElementById("query").value;
    //search API link
    const url = `https://www.googleapis.com/books/v1/volumes?q=${query}&maxResults=10`;

    //based on query value fetches data from Google Books API
    fetch(url)
        .then(response => response.json())
        .then(data => {
            displayBooks(data.items); 
        })
        .catch(error => {
            console.error("Error fetching books:", error);
        });
}

function displayBooks(books) {
    const bookResults = document.getElementById("book-results");
    bookResults.innerHTML = ''; // Clear previous results

    //creates a bookcard that hold information of book from query
    if (books && books.length > 0) {
        books.forEach(book => {
            const bookInfo = book.volumeInfo;
            const bookCard = document.createElement("div");
            bookCard.classList.add("book-card");

            // Get book image or use placeholder
            const bookImage = bookInfo.imageLinks ? bookInfo.imageLinks.thumbnail : 'https://via.placeholder.com/150';
            //displays book image, title, author, publisher, published date and ISBN in the bookcard
            bookCard.innerHTML = `
                <img src="${bookImage}" alt="${bookInfo.title}">
                <h3>${bookInfo.title}</h3>
                <p><strong>Author(s):</strong> ${bookInfo.authors ? bookInfo.authors.join(', ') : 'N/A'}</p>
                <p><strong>Publisher:</strong> ${bookInfo.publisher || 'N/A'}</p>
                <p><strong>Published:</strong> ${bookInfo.publishedDate || 'N/A'}</p>
                <p><strong>ISBN:</strong> ${bookInfo.industryIdentifiers ? bookInfo.industryIdentifiers[0].identifier : 'N/A'}</p>
            `;

            bookResults.appendChild(bookCard);
        });
    } else {
        bookResults.innerHTML = '<p>No books found. Please try another search.</p>';
    }
}
