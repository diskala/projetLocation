const carouselContainer = document.querySelector('.carousel-container');
const slides = document.querySelector('.slides');
const slideItems = document.querySelectorAll('.slide');
const prevButton = document.getElementById('prev');
const nextButton = document.getElementById('next');

let currentIndex = 0;
const totalSlides = slideItems.length - 1; // On soustrait 1 car la dernière image est dupliquée
const slideWidth = slideItems[0].offsetWidth;

// Fonction pour afficher le diaporama suivant
function nextSlide() {
    currentIndex = (currentIndex + 1) % (totalSlides + 1); // +1 car la dernière image est dupliquée
    updateSlidePosition();
}

// Fonction pour afficher le diaporama précédent
function prevSlide() {
    currentIndex = (currentIndex - 1 + totalSlides + 1) % (totalSlides + 1); // +1 car la dernière image est dupliquée
    updateSlidePosition();
}

// Fonction pour mettre à jour la position du diaporama
function updateSlidePosition() {
    slides.style.transition = 'transform 1s ease';

    if (currentIndex === totalSlides) {
        slides.style.transform = `translateX(-${(currentIndex + 1) * slideWidth}px)`;
        setTimeout(() => {
            slides.style.transition = 'none';
            slides.style.transform = `translateX(0)`;
            currentIndex = 0;
        }, 500);
    } else {
        slides.style.transform = `translateX(-${currentIndex * slideWidth}px)`;
    }
}

    // Événements des boutons précédent et suivant
    // prevButton.addEventListener('click',  nextSlide);
    // nextButton.addEventListener('click', prevSlide);

    // Défilement automatique
    setInterval(nextSlide, 5000); // Change slide every 3 seconds



const achats=document.querySelector('.achat');
const num= document.querySelector('.numero');
 achats.addEventListener('click', ()=>{
num.style.zIndex="1200";
achats.style.visibility="hidden";
num.style.visibility="visible";
 
 })

 num.addEventListener('click', ()=>{
    num.style.zIndex="0";
    achats.style.visibility="visible";
    num.style.visibility="hidden";
 })
 

 



 