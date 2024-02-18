document.addEventListener('DOMContentLoaded', function () {
    const burgerMenu = document.querySelector('.burger-menu');
   
    const navLinks = document.querySelector('.nav-links');
    
    burgerMenu.addEventListener('click', function () {
        
        navLinks.style.display = (navLinks.style.display === 'block' ? 'none' : 'block');
    });


    // Ajoutez un gestionnaire d'événements au redimensionnement de la fenêtre
// window.addEventListener('resize', function () {
//     // Réinitialisez le style des liens de navigation si la largeur de la fenêtre est supérieure à un certain seuil
//     if (window.innerWidth > 1200) { // Mettez la valeur qui convient à votre conception responsive
//         navLinks.style.display = 'flex';
//     }
//     if (window.innerWidth < 1200) { // Mettez la valeur qui convient à votre conception responsive
//         navLinks.style.display = 'block';
//     }
// });

    var accueilLink = document.getElementById('accueil');
    var serviceLink = document.getElementById('service');
    var sousMenuAccueil = document.querySelector(".sous_accueil");
    var sousMenuService = document.querySelector(".sous_service");
    var heads= document.querySelector('.container_header');
    
   
    accueilLink.addEventListener('mouseover', function () {
        sousMenuAccueil.style.display = 'block';
        
        sousMenuService.style.display = 'none';
        
    
        
    });

    accueilLink.addEventListener('mouseout', function () {
        sousMenuAccueil.style.display = 'none';
        
        
    });


    sousMenuAccueil.addEventListener('mouseover', function () {
        sousMenuAccueil.style.display = 'block';
    });

    sousMenuAccueil.addEventListener('mouseout', function () {
        sousMenuAccueil.style.display = 'none';
        
    });



    serviceLink.addEventListener('mouseover', function () {
        sousMenuService.style.display = 'block';
        sousMenuAccueil.style.display = 'none';
    });

    serviceLink.addEventListener('mouseout', function () {
        sousMenuService.style.display = 'none';
        
    });

     

    sousMenuService.addEventListener('mouseover', function () {
        sousMenuService.style.display = 'block';
    });

    sousMenuService.addEventListener('mouseout', function () {
        sousMenuService.style.display = 'none';
    });
});
 

 