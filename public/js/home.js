window.addEventListener('load', function () {
    const carouselContainer = document.querySelector('.carousel-container');
    const slides = document.querySelector('.slides');
    const slideItems = document.querySelectorAll('.slide');
    const prevButton = document.getElementById('prev');
    const nextButton = document.getElementById('next');

    let currentIndex = 0;
    const totalSlides = slideItems.length;
    const slideWidth = slideItems[0].offsetWidth;

    // Positionne le carousel au début
    slides.style.transform = `translateX(0px)`;

    function updateSlidePosition() {
        slides.style.transition = 'transform 1s ease';
        slides.style.transform = `translateX(-${currentIndex * slideWidth}px)`;
    }

    function nextSlide() {
        currentIndex = (currentIndex + 1) % totalSlides;
        updateSlidePosition();
    }
    nextSlide();

    function prevSlide() {
        currentIndex = (currentIndex - 1 + totalSlides) % totalSlides;
        updateSlidePosition();
    }

    // prevButton.addEventListener('click', nextSlide);
    // nextButton.addEventListener('click', prevSlide);

    setInterval(nextSlide, 5000);
});




const achats=document.querySelector('.div_achat');
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
 

 



 