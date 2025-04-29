function toggleDropdown() {
    const dropdown = document.getElementById("dropdown-menu");
    const chevron = document.querySelector(".dropdown-chevron");
    const content = dropdown ? dropdown.querySelector(".dropdown-content") : null;

    if (!dropdown || !chevron || !content) {
        console.error("Erreur : un élément est manquant !");
        return;
    }

    dropdown.classList.toggle("show"); // <<<<<<<<<< ajoute show pour rendre visible
    dropdown.classList.toggle("active"); // <<<<<<<<<< ajoute active pour le chevron

    if (content.style.maxHeight) {
        content.style.maxHeight = null;
    } else {
        content.style.maxHeight = content.scrollHeight + "px";
    }

    chevron.style.transform = dropdown.classList.contains("active")
        ? "rotate(180deg)"
        : "rotate(0deg)";
}
