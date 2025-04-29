// script.js

// Variable pour bloquer le défilement pendant l'animation
let isScrolling = false;  
// Stocke l'heure du dernier événement de scroll
let lastScrollTime = 0;  
// Seuil du temps entre chaque événement de scroll (en ms)
const scrollThreshold = 300; 
// Toutes les sections de la page
const sections = document.querySelectorAll('section');  

// Index de la section actuelle
let currentIndex = 0;  

/**
 * Fonction pour défiler vers la section donnée.
 * @param {number} index - L'index de la section à défiler.
 */
function scrollToSection(index) {
    // Vérification si l'index est valide
    if (index >= 0 && index < sections.length) {
        // Défilement vers la section, avec l'option smooth pour un défilement fluide
        sections[index].scrollIntoView({
            behavior: 'smooth',  // Défilement fluide
            block: 'start',
        });
    }
}

// Gestion du défilement avec la molette
window.addEventListener('wheel', function (e) {
    // Si une animation est en cours, on ignore l'événement
    if (isScrolling) return;

    // Récupération du temps actuel
    const currentTime = Date.now(); 

    // Si le temps entre deux événements est trop court, on ignore l'événement
    if (currentTime - lastScrollTime < scrollThreshold) return;

    // Marquer le dernier temps de scroll
    lastScrollTime = currentTime;

    // Empêcher le défilement vertical standard
    e.preventDefault();

    // Déterminer la direction du défilement (vers le bas ou vers le haut)
    if (e.deltaY > 0) {
        // Si on descend, passer à la section suivante
        if (currentIndex < sections.length - 1) {
            currentIndex++;
        }
    } else {
        // Si on monte, revenir à la section précédente
        if (currentIndex > 0) {
            currentIndex--;
        }
    }

    // Effectuer le défilement vers la section suivante ou précédente
    scrollToSection(currentIndex);

    // Activer l'animation et empêcher un autre défilement pendant celle-ci
    isScrolling = true;

    // Réinitialiser l'état d'animation après 1 seconde (durée de l'animation)
    setTimeout(() => {
        isScrolling = false;
    }, 1000);  // 1 seconde pour garantir une animation fluide
});
