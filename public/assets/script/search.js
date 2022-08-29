const searchForm = document.getElementById("search-form");
const searchInput = document.getElementById("search-input");

searchForm.addEventListener('submit', (e) => {
    window.location.href = `/search/${encodeURIComponent(searchInput.value)}`;
    e.preventDefault();
});
