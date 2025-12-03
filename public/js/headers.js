class Header {
    constructor() {
        this.header = document.querySelector('.container_header');
        this.burgerMenu = document.querySelector('.burger-menu');
        this.navLinks = document.querySelector('.nav-links');
        this.init();
    }
    
    init() {
        // Scroll effect
        window.addEventListener('scroll', () => this.handleScroll());
        
        // Burger menu
        if (this.burgerMenu) {
            this.burgerMenu.addEventListener('click', () => this.toggleMenu());
        }
        
        // Fermer le menu en cliquant à l'extérieur
        document.addEventListener('click', (e) => this.handleClickOutside(e));
        
        // Fermer le menu en cliquant sur un lien
        this.navLinks?.addEventListener('click', (e) => {
            if (e.target.tagName === 'A') {
                this.closeMenu();
            }
        });
    }
    
    handleScroll() {
        if (window.scrollY > 100) {
            this.header.classList.add('scrolled');
        } else {
            this.header.classList.remove('scrolled');
        }
    }
    
    toggleMenu() {
        this.navLinks.classList.toggle('active');
        this.burgerMenu.textContent = this.navLinks.classList.contains('active') ? '✕' : '☰';
    }
    
    closeMenu() {
        this.navLinks.classList.remove('active');
        this.burgerMenu.textContent = '☰';
    }
    
    handleClickOutside(e) {
        if (!this.header.contains(e.target)) {
            this.closeMenu();
        }
    }
}

// Initialisation
document.addEventListener('DOMContentLoaded', () => {
    new Header();
});

// Gestion des menus déroulants au hover sur mobile
document.addEventListener('DOMContentLoaded', () => {
    const menuItems = document.querySelectorAll('.menu_accueil, .menu_service');
    
    menuItems.forEach(item => {
        if (window.innerWidth <= 768) {
            item.addEventListener('click', (e) => {
                if (e.target === item.querySelector('a')) {
                    e.preventDefault();
                    const submenu = item.querySelector('ul');
                    if (submenu) {
                        submenu.style.display = submenu.style.display === 'block' ? 'none' : 'block';
                    }
                }
            });
        }
    });
});





// document.addEventListener('DOMContentLoaded', function () {
//     const burgerMenu = document.querySelector('.burger-menu');
//     const contenairehead = document.querySelector('.container_header');
   
//     const navLinks = document.querySelector('.nav-links');
    
//     burgerMenu.addEventListener('click', function () {
        
//         navLinks.style.display = (navLinks.style.display === 'block' ? 'none' : 'block');
//         contenairehead.style.height=(contenairehead.style.height==='20rem'?'5rem':'20rem');
//     });


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

//     var accueilLink = document.getElementById('accueil');
//     var serviceLink = document.getElementById('service');
//     var sousMenuAccueil = document.querySelector(".sous_accueil");
//     var sousMenuService = document.querySelector(".sous_service");
//     var heads= document.querySelector('.container_header');
    
   
//     accueilLink.addEventListener('mouseover', function () {
//         sousMenuAccueil.style.display = 'block';
        
//         sousMenuService.style.display = 'none';
        
    
        
//     });

//     accueilLink.addEventListener('mouseout', function () {
//         sousMenuAccueil.style.display = 'none';
        
        
//     });


//     sousMenuAccueil.addEventListener('mouseover', function () {
//         sousMenuAccueil.style.display = 'block';
//     });

//     sousMenuAccueil.addEventListener('mouseout', function () {
//         sousMenuAccueil.style.display = 'none';
        
//     });



//     serviceLink.addEventListener('mouseover', function () {
//         sousMenuService.style.display = 'block';
//         sousMenuAccueil.style.display = 'none';
//     });

//     serviceLink.addEventListener('mouseout', function () {
//         sousMenuService.style.display = 'none';
        
//     });

     

//     sousMenuService.addEventListener('mouseover', function () {
//         sousMenuService.style.display = 'block';
//     });

//     sousMenuService.addEventListener('mouseout', function () {
//         sousMenuService.style.display = 'none';
//     });
// });