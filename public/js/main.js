// Gestion du scroll pour la navbar
// Cette fonctionnalité permet de modifier l'apparence de la navbar en fonction de la position de défilement de la page
document.addEventListener('DOMContentLoaded', () => {
    // Sélection de la navbar
    const navbar = document.querySelector('.navbar');
    // Variable pour stocker la dernière position de défilement, utilisée pour déterminer la direction du scroll
    let lastScroll = 0;

    // Écouteur d'événement pour le défilement de la page
    window.addEventListener('scroll', () => {
        // Récupération de la position actuelle de défilement
        const currentScroll = window.pageYOffset;

        // Ajoute/supprime la classe scrolled en fonction du scroll
        // Cette classe permet de modifier l'apparence de la navbar
        if (currentScroll > 50) {
            navbar.classList.add('scrolled');
        } else {
            navbar.classList.remove('scrolled');
        }

        // Mise à jour de la dernière position de défilement
        lastScroll = currentScroll;
    });

    // Animation des images au scroll
    // Cette fonctionnalité permet d'animer les images lorsqu'elles entrent dans le champ de vision
    const observerOptions = {
        root: null,
        rootMargin: '0px',
        threshold: 0.1
    };

    // Création d'un objet IntersectionObserver pour détecter les entrées dans le champ de vision
    const observer = new IntersectionObserver((entries) => {
        // Boucle sur les entrées détectées
        entries.forEach(entry => {
            // Si l'entrée est dans le champ de vision
            if (entry.isIntersecting) {
                // Animation de l'image
                entry.target.style.opacity = '1';
                entry.target.style.transform = 'translateY(0)';
            }
        });
    }, observerOptions);

    // Applique l'animation à toutes les sections de voitures
    // Cette fonctionnalité permet d'animer les sections de voitures lorsqu'elles entrent dans le champ de vision
    document.querySelectorAll('.widget').forEach(widget => {
        // Initialisation de l'opacité et de la position de l'image
        widget.style.opacity = '0';
        widget.style.transform = 'translateY(20px)';
        // Définition de la transition pour l'animation
        widget.style.transition = 'all 0.6s ease-out';
        // Observation de l'image pour détecter les entrées dans le champ de vision
        observer.observe(widget);
    });

    // Smooth scroll pour les liens de navigation
    // Cette fonctionnalité permet de faire défiler la page de manière fluide lorsqu'un lien de navigation est cliqué
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        // Écouteur d'événement pour le clic sur le lien
        anchor.addEventListener('click', function (e) {
            // Empêche le comportement par défaut du lien
            e.preventDefault();
            // Fait défiler la page jusqu'à l'élément ciblé par le lien
            document.querySelector(this.getAttribute('href')).scrollIntoView({
                behavior: 'smooth'
            });
        });
    });
});
