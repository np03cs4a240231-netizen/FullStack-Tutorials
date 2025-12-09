const API_URL = "http://localhost:3000/movies";

const movieListDiv = document.getElementById("movie-list");
const searchInput = document.getElementById("search-input");
const form = document.getElementById("add-movie-form");

let allMovies = [];

// Render movies
function renderMovies(moviesToDisplay) {
  movieListDiv.innerHTML = "";

  if (moviesToDisplay.length === 0) {
    movieListDiv.innerHTML = "<p>No movies found matching your criteria.</p>";
    return;
  }

  moviesToDisplay.forEach((movie) => {
    const movieElement = document.createElement("div");
    movieElement.classList.add("movie-item");

    movieElement.innerHTML = `
      <p><strong>${movie.title}</strong> (${movie.year}) - ${movie.genre}</p>
      <button class="edit-btn">Edit</button>
      <button class="delete-btn">Delete</button>
    `;

    // SAFE event listeners — no inline onclick
    movieElement.querySelector(".edit-btn").addEventListener("click", () => {
      editMoviePrompt(movie.id, movie.title, movie.year, movie.genre);
    });

    movieElement.querySelector(".delete-btn").addEventListener("click", () => {
      deleteMovie(movie.id);
    });

    movieListDiv.appendChild(movieElement);
  });
}

// Fetch movies
function fetchMovies() {
  fetch(API_URL)
    .then((response) => response.json())
    .then((movies) => {
      allMovies = movies;
      renderMovies(allMovies);
    })
    .catch((error) => console.error("Error fetching movies:", error));
}
fetchMovies();

// Search
searchInput.addEventListener("input", function () {
  const term = searchInput.value.toLowerCase();

  const filtered = allMovies.filter((movie) => {
    return (
      movie.title.toLowerCase().includes(term) ||
      movie.genre.toLowerCase().includes(term)
    );
  });

  renderMovies(filtered);
});

// Add movie
form.addEventListener("submit", function (event) {
  event.preventDefault();

  const newMovie = {
    title: document.getElementById("title").value,
    genre: document.getElementById("genre").value,
    year: parseInt(document.getElementById("year").value),
  };

  fetch(API_URL, {
    method: "POST",
    headers: { "Content-Type": "application/json" },
    body: JSON.stringify(newMovie),
  })
    .then((res) => res.json())
    .then(() => {
      form.reset();
      fetchMovies();
    });
});

// Edit movie
function editMoviePrompt(id, currentTitle, currentYear, currentGenre) {
  const newTitle = prompt("Enter new Title:", currentTitle);
  const newYear = prompt("Enter new Year:", currentYear);
  const newGenre = prompt("Enter new Genre:", currentGenre);

  if (newTitle && newYear && newGenre) {
    updateMovie(id, {
      id,
      title: newTitle,
      year: parseInt(newYear),
      genre: newGenre,
    });
  }
}

// Update movie
function updateMovie(id, updatedMovie) {
  fetch(`${API_URL}/${id}`, {
    method: "PUT",
    headers: { "Content-Type": "application/json" },
    body: JSON.stringify(updatedMovie),
  })
    .then((res) => res.json())
    .then(() => fetchMovies());
}

// Delete movie
function deleteMovie(id) {
  fetch(`${API_URL}/${id}`, {
    method: "DELETE",
  })
    .then(() => fetchMovies())
    .catch((error) => console.error("Error deleting movie:", error));
}
