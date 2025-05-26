// Carrousel automatique pour la page d'accueil
document.addEventListener('DOMContentLoaded', function() {
    let currentIndex = 0;
    const carouselItems = document.querySelectorAll('.carousel-item');
    const totalItems = carouselItems.length;
    const carouselInner = document.querySelector('.carousel-inner');

    if (!carouselInner || totalItems === 0) return;

    // Fonction pour afficher un élément spécifique
    function showItem(index) {
        const translateValue = `translateX(-${index * 100}%)`;
        carouselInner.style.transform = translateValue;
    }

    // Fonction pour passer à l'élément suivant
    function nextItem() {
        currentIndex = (currentIndex + 1) % totalItems;
        showItem(currentIndex);
    }

    // Fonction pour passer à l'élément précédent
    function prevItem() {
        currentIndex = (currentIndex - 1 + totalItems) % totalItems;
        showItem(currentIndex);
    }

    // Initialisation
    carouselInner.style.transition = 'transform 0.8s ease-in-out';
    showItem(currentIndex);

    // Démarrer le carrousel automatique
    let autoSlide = setInterval(nextItem, 5000);

    // Ajouter les contrôles si ils existent
    const nextBtn = document.querySelector('.carousel-next');
    const prevBtn = document.querySelector('.carousel-prev');

    if (nextBtn) {
        nextBtn.addEventListener('click', () => {
            clearInterval(autoSlide);
            nextItem();
            autoSlide = setInterval(nextItem, 5000);
        });
    }

    if (prevBtn) {
        prevBtn.addEventListener('click', () => {
            clearInterval(autoSlide);
            prevItem();
            autoSlide = setInterval(nextItem, 5000);
        });
    }

    // Pause au survol du carrousel
    carouselInner.addEventListener('mouseenter', () => {
        clearInterval(autoSlide);
    });

    carouselInner.addEventListener('mouseleave', () => {
        autoSlide = setInterval(nextItem, 5000);
    });
});

// Animations d'entrée pour les éléments de la page
function animateOnScroll() {
    const elements = document.querySelectorAll('.fade-in, .slide-up');
    
    elements.forEach(element => {
        const elementTop = element.getBoundingClientRect().top;
        const elementVisible = 150;
        
        if (elementTop < window.innerHeight - elementVisible) {
            element.classList.add('active');
        }
    });
}

// Effet de scroll fluide pour les liens d'ancrage
document.querySelectorAll('a[href^="#"]').forEach(anchor => {
    anchor.addEventListener('click', function (e) {
        e.preventDefault();
        const target = document.querySelector(this.getAttribute('href'));
        if (target) {
            target.scrollIntoView({
                behavior: 'smooth',
                block: 'start'
            });
        }
    });
});

// Événements de scroll et de chargement
window.addEventListener('scroll', animateOnScroll);
window.addEventListener('load', animateOnScroll);





