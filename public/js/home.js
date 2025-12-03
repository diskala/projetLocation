// Carousel functionality - Version corrigée et simplifiée
class Carousel {
    constructor() {
        this.track = document.getElementById('carouselTrack');
        this.slides = document.querySelectorAll('.carousel-slide');
        this.prevBtn = document.getElementById('prevBtn');
        this.nextBtn = document.getElementById('nextBtn');
        this.currentIndex = 0;
        this.slideCount = this.slides.length;
        this.slidesToShow = this.getSlidesToShow();
        
        this.init();
    }
    
    getSlidesToShow() {
        if (window.innerWidth < 768) return 1;
        if (window.innerWidth < 1024) return 2;
        return 3;
    }
    
    init() {
        // Vérifier que les éléments existent
        if (!this.track || !this.prevBtn || !this.nextBtn) {
            console.error('Éléments du carousel non trouvés');
            return;
        }
        
        this.prevBtn.addEventListener('click', () => this.prev());
        this.nextBtn.addEventListener('click', () => this.next());
        
        // Redimensionnement de la fenêtre
        window.addEventListener('resize', () => {
            this.slidesToShow = this.getSlidesToShow();
            this.updateCarousel();
        });
        
        this.updateCarousel();
        this.startAutoPlay();
        
        console.log('Carousel initialisé avec', this.slideCount, 'slides');
    }
    
    next() {
        const maxIndex = this.slideCount - this.slidesToShow;
        this.currentIndex = (this.currentIndex + 1) % (maxIndex + 1);
        this.updateCarousel();
    }
    
    prev() {
        const maxIndex = this.slideCount - this.slidesToShow;
        this.currentIndex = (this.currentIndex - 1 + (maxIndex + 1)) % (maxIndex + 1);
        this.updateCarousel();
    }
    
    updateCarousel() {
        if (!this.track) return;
        
        const slideWidth = this.slides[0]?.offsetWidth + 20; // 20px pour le gap
        const translateX = -this.currentIndex * slideWidth;
        
        this.track.style.transform = `translateX(${translateX}px)`;
        this.track.style.transition = 'transform 0.5s ease';
    }
    
    startAutoPlay() {
        setInterval(() => {
            this.next();
        }, 5000); // Change toutes les 5 secondes
    }
}

// Smooth scroll
function initSmoothScroll() {
    const scrollIndicator = document.querySelector('.scroll-indicator');
    if (scrollIndicator) {
        scrollIndicator.addEventListener('click', () => {
            window.scrollTo({
                top: window.innerHeight,
                behavior: 'smooth'
            });
        });
    }
}

// Animation on scroll
function initAnimations() {
    const observerOptions = {
        threshold: 0.1,
        rootMargin: '0px 0px -50px 0px'
    };
    
    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.style.opacity = '1';
                entry.target.style.transform = 'translateY(0)';
            }
        });
    }, observerOptions);
    
    // Observer les éléments pour l'animation
    document.querySelectorAll('.advantage-card, .section-title').forEach(el => {
        el.style.opacity = '0';
        el.style.transform = 'translateY(30px)';
        el.style.transition = 'opacity 0.6s ease, transform 0.6s ease';
        observer.observe(el);
    });
}

// Gestionnaire du bouton de contact
function initContactButton() {
    const contactBtn = document.getElementById('appel');
    if (contactBtn) {
        contactBtn.addEventListener('click', () => {
            // Ouvrir le modal de contact ou rediriger
            alert('Fonctionnalité de rappel - À intégrer avec votre système de contact');
            // Vous pouvez intégrer votre logique de modal ici
        });
    }
}

// Initialisation quand le DOM est chargé
document.addEventListener('DOMContentLoaded', function() {
    console.log('Initialisation du site...');
    
    // Initialiser le carousel
    new Carousel();
    
    // Initialiser les autres fonctionnalités
    initSmoothScroll();
    initAnimations();
    initContactButton();
    
    console.log('Site initialisé avec succès');
});

// Fallback si le carousel a des problèmes
document.addEventListener('DOMContentLoaded', function() {
    // Vérification que le carousel fonctionne
    setTimeout(() => {
        const track = document.getElementById('carouselTrack');
        if (track && track.style.transform === '') {
            console.log('Redémarrage du carousel...');
            new Carousel();
        }
    }, 1000);
});




// window.addEventListener('load', function () {
//     const carouselContainer = document.querySelector('.carousel-container');
//     const slides = document.querySelector('.slides');
//     const slideItems = document.querySelectorAll('.slide');
//     const prevButton = document.getElementById('prev');
//     const nextButton = document.getElementById('next');

//     let currentIndex = 0;
//     const totalSlides = slideItems.length;
//     const slideWidth = slideItems[0].offsetWidth;

//     // Positionne le carousel au début
//     slides.style.transform = `translateX(0px)`;

//     function updateSlidePosition() {
//         slides.style.transition = 'transform 1s ease';
//         slides.style.transform = `translateX(-${currentIndex * slideWidth}px)`;
//     }

//     function nextSlide() {
//         currentIndex = (currentIndex + 1) % totalSlides;
//         updateSlidePosition();
//     }
//     nextSlide();

//     function prevSlide() {
//         currentIndex = (currentIndex - 1 + totalSlides) % totalSlides;
//         updateSlidePosition();
//     }

//     // prevButton.addEventListener('click', nextSlide);
//     // nextButton.addEventListener('click', prevSlide);

//     setInterval(nextSlide, 5000);
// });




// const achats=document.querySelector('.div_achat');
// const num= document.querySelector('.numero');
//  achats.addEventListener('click', ()=>{
// num.style.zIndex="1200";
// achats.style.visibility="hidden";
// num.style.visibility="visible";
 
//  })

//  num.addEventListener('click', ()=>{
//     num.style.zIndex="0";
//     achats.style.visibility="visible";
//     num.style.visibility="hidden";
//  })
 

 



 