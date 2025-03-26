// Fonction pour activer/désactiver le menu déroulant
function toggleDropdown() {
    // Sélection des éléments du DOM
    const dropdown = document.getElementById("dropdown-menu");
    const chevron = document.querySelector(".dropdown-chevron");
    const content = dropdown.querySelector(".dropdown-content");
    
    // Activation/désactivation du menu
    dropdown.classList.toggle("active");
    
    // Animation fluide
    if (content.style.maxHeight) {
        content.style.maxHeight = null;
    } else {
        content.style.maxHeight = content.scrollHeight + "px";
    }
    
    // Rotation du chevron
    chevron.style.transform = dropdown.classList.contains("active") 
        ? "rotate(180deg)"
        : "rotate(0deg)";
}