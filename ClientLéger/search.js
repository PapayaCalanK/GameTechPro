document.addEventListener("DOMContentLoaded", function () {
  const searchInput = document.getElementById("search-input");
  const productsContainer = document.getElementById("products-container");

  // Sécurisation JS + TS
  if (!searchInput || !productsContainer) return;
  if (!(searchInput instanceof HTMLInputElement)) return;

  searchInput.addEventListener("input", function () {
    const query = searchInput.value.trim();

    // Requête AJAX
    const xhr = new XMLHttpRequest();
    xhr.open("GET", `search.php?query=${encodeURIComponent(query)}`, true);

    xhr.onload = function () {
      if (xhr.status === 200) {
        productsContainer.innerHTML = xhr.responseText;
      }
    };

    xhr.send();
  });
});
