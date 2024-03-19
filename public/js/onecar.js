 
 

 


document.addEventListener('DOMContentLoaded', function () {
    let currentSlide = 0;
    const totalSlides = document.querySelectorAll('.picture').length;

    document.getElementById('controlApres').addEventListener('click', function () {
        nextSlide();
    });

    document.getElementById('controlAvant').addEventListener('click', function () {
        prevSlide();
    });

    function nextSlide() {
        if (currentSlide < totalSlides - 1) {
            currentSlide++;
        } else {
            currentSlide = 0;
        }
        updateCarousel();
    }

    function prevSlide() {
        if (currentSlide > 0) {
            currentSlide--;
        } else {
            currentSlide = totalSlides - 1;
        }
        updateCarousel();
    }

    function updateCarousel() {
        const newTransformValue = -currentSlide * 100 + '%';
        document.querySelector('.slick-carousel').style.transform = 'translateX(' + newTransformValue + ')';
    }
});
    

 
 

 
 
      
  
//Sélection des éléments <hr> et <li>
const hrElements = document.querySelectorAll('hr');
const liElements = document.querySelectorAll('li');

// Fonction pour agrandir l'élément
function enlargeElement(element) {
    // element.nextElementSibling.style.display = "block";
    element.nextElementSibling.style.width = "50%";
    element.nextElementSibling.style.transition = "1s ease-in-out";
}

// Fonction pour rétablir la taille normale de l'élément
function restoreElementSize(element) {
    // element.nextElementSibling.style.display = "none";
    element.nextElementSibling.style.width = "5%";
}

// Ajout des écouteurs d'événements pour chaque élément <li>
liElements.forEach(element => {
    element.addEventListener('mouseover', () => {
        enlargeElement(element);
    });

    element.addEventListener('mouseout', () => {
        restoreElementSize(element);
    });
});


 

