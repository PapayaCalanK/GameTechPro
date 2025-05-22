document.addEventListener("DOMContentLoaded", function () {
  const searchInput = document.getElementById("search-input");
  const searchResults = document.getElementById("search-results");

  if (!searchInput || !searchResults) return;
  if (!(searchInput instanceof HTMLInputElement)) return;

  searchInput.addEventListener("keyup", function () {
    const query = searchInput.value.trim();

    if (query.length > 0) {
      fetch("search.php?query=" + encodeURIComponent(query))
        .then((response) => response.text())
        .then((data) => {
          searchResults.innerHTML = data;
          searchResults.style.display = "block";
        });
    } else {
      searchResults.style.display = "none";
    }
  });

  document.addEventListener("click", function (event) {
    const target = event.target;
    if (
      target instanceof Node &&
      !searchResults.contains(target) &&
      target !== searchInput
    ) {
      searchResults.style.display = "none";
    }
  });
});
