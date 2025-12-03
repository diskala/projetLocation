class AllCarsPage {
  constructor() {
    this.form = document.getElementById("formulaire");
    this.marqueSelect = document.querySelector(".marque");
    this.categorieSelect = document.querySelector(".categorie");
    this.container = document.getElementById("container_items");
    this.init();
  }

  init() {
    // Auto-submit du formulaire lors du changement des selects
    if (this.marqueSelect && this.categorieSelect) {
      this.marqueSelect.addEventListener("change", () =>
        this.handleFilterChange()
      );
      this.categorieSelect.addEventListener("change", () =>
        this.handleFilterChange()
      );
    }

    // Animation au scroll
    this.initScrollAnimations();

    // Gestion des états de loading
    this.initLoadingStates();
  }

  handleFilterChange() {
    // Ajouter une classe de loading
    this.container.classList.add("loading");

    // Soumettre le formulaire après un petit délai pour l'animation
    setTimeout(() => {
      this.form.submit();
    }, 300);

    // Highlight des filtres actifs
    this.highlightActiveFilters();
  }

  highlightActiveFilters() {
    const selects = [this.marqueSelect, this.categorieSelect];

    selects.forEach((select) => {
      if (select && select.value !== "") {
        select.classList.add("filter-active");
      } else {
        select.classList.remove("filter-active");
      }
    });
  }

  initScrollAnimations() {
    const observerOptions = {
      threshold: 0.1,
      rootMargin: "0px 0px -50px 0px",
    };

    const observer = new IntersectionObserver((entries) => {
      entries.forEach((entry) => {
        if (entry.isIntersecting) {
          entry.target.style.opacity = "1";
          entry.target.style.transform = "translateY(0)";
        }
      });
    }, observerOptions);

    // Observer les cartes de véhicules
    document.querySelectorAll(".items").forEach((item, index) => {
      item.style.opacity = "0";
      item.style.transform = "translateY(30px)";
      item.style.transition = `opacity 0.6s ease, transform 0.6s ease ${
        index * 0.1
      }s`;
      observer.observe(item);
    });
  }

  initLoadingStates() {
    // Simulation de chargement pour la démo
    const links = document.querySelectorAll(".lien");

    links.forEach((link) => {
      link.addEventListener("click", (e) => {
        if (!link.href) {
          e.preventDefault();
          this.showLoadingState(link);
        }
      });
    });
  }

  showLoadingState(element) {
    const originalText = element.textContent;
    element.textContent = "Chargement...";
    element.style.opacity = "0.7";

    setTimeout(() => {
      element.textContent = originalText;
      element.style.opacity = "1";
    }, 1500);
  }

  // Filtrage côté client (optionnel)
  filterCars() {
    const marqueValue = this.marqueSelect?.value.toLowerCase() || "";
    const categorieValue = this.categorieSelect?.value.toLowerCase() || "";

    document.querySelectorAll(".items").forEach((item) => {
      const brand = item.querySelector("h2 a").textContent.toLowerCase();
      const shouldShow =
        (marqueValue === "" || brand.includes(marqueValue)) &&
        (categorieValue === "" || brand.includes(categorieValue));

      item.style.display = shouldShow ? "block" : "none";
      item.style.opacity = shouldShow ? "1" : "0.3";
    });
  }
}

// Initialisation
document.addEventListener("DOMContentLoaded", () => {
  new AllCarsPage();

  // Ajouter un effet de parallaxe au scroll
  window.addEventListener("scroll", () => {
    const scrolled = window.pageYOffset;
    const parallax = document.querySelector("#carre");
    if (parallax) {
      parallax.style.backgroundPosition = `center ${scrolled * 0.5}px`;
    }
  });
});

// Gestion des erreurs d'images
document.addEventListener("DOMContentLoaded", () => {
  const images = document.querySelectorAll(".pic img");

  images.forEach((img) => {
    img.addEventListener("error", function () {
      this.src = "/images/placeholder-car.jpg";
      this.alt = "Image non disponible";
    });
  });
});

// const formul=document.getElementById('formulaire');
// const marq=document.querySelector('.marque');

// // Remplir automatiquement le champ
//  if(marq.value !==null){
//     formul.addEventListener('input', ()=>{

//     })
//  }

// Soumettre automatiquement le formulaire

//  document.addEventListener('DOMContentLoaded', function() {
//     const marq=document.querySelector('.marque');

//     const formul=document.getElementById('formulaire');
//          if(marq.value !==null){
//             marq.addEventListener('input', function() {
//                 // Soumet automatiquement le formulaire
//                 marq.form.submit();
//             });
//          }

//     });

//     document.addEventListener('DOMContentLoaded', function() {

//         const formul=document.getElementById('formulaire');

//         const categ=document.querySelector('.categorie');
//                 if(categ.value !==null){
//                     categ.addEventListener('input', function() {
//                         // Soumet automatiquement le formulaire
//                         categ.form.submit();
//                     });
//                 }

//         });
