import { Image } from "react-native";
document.addEventListener("DOMContentLoaded", function () {
  console.log("🚗 Initialisation du carousel flex...");

  // Trouver le carousel
  const carousel = document.querySelector(".slick-carousel");
  if (!carousel) {
    console.error("❌ Carousel non trouvé");
    return;
  }

  const pictures = carousel.querySelectorAll(".picture");
  const prevBtn = document.getElementById("controlApres");
  const nextBtn = document.getElementById("controlAvant");

  console.log(`📸 ${pictures.length} images trouvées`);

  if (pictures.length === 0) {
    console.error("❌ Aucune image trouvée");
    return;
  }

  let currentSlide = 0;
  let autoPlayInterval;

  // Fonction pour déplacer le carousel
  function moveCarousel() {
    const translateX = -currentSlide * 100;
    carousel.style.transform = `translateX(${translateX}%)`;
    updateIndicators();
    console.log(
      `🔄 Déplacement à la slide ${currentSlide}, translateX: ${translateX}%`
    );
  }

  // Fonction pour créer les indicateurs
  function createIndicators() {
    const indicatorsContainer = document.createElement("div");
    indicatorsContainer.className = "slide-indicators";

    pictures.forEach((_, index) => {
      const indicator = document.createElement("div");
      indicator.className = "slide-indicator";
      if (index === 0) indicator.classList.add("active");

      indicator.addEventListener("click", () => {
        console.log(`📍 Indicateur cliqué: ${index}`);
        stopAutoPlay();
        currentSlide = index;
        moveCarousel();
        startAutoPlay();
      });

      indicatorsContainer.appendChild(indicator);
    });

    document.getElementById("picCar").appendChild(indicatorsContainer);
  }

  // Fonction pour mettre à jour les indicateurs
  function updateIndicators() {
    const indicators = document.querySelectorAll(".slide-indicator");
    indicators.forEach((indicator, index) => {
      indicator.classList.toggle("active", index === currentSlide);
    });
  }

  // Fonction slide suivant
  function nextSlide() {
    console.log("➡️ Slide suivant");
    currentSlide = (currentSlide + 1) % pictures.length;
    moveCarousel();
  }

  // Fonction slide précédent
  function prevSlide() {
    console.log("⬅️ Slide précédent");
    currentSlide = (currentSlide - 1 + pictures.length) % pictures.length;
    moveCarousel();
  }

  // Auto-play
  function startAutoPlay() {
    console.log("▶️ Démarrage auto-play");
    stopAutoPlay();
    autoPlayInterval = setInterval(nextSlide, 4000);
  }

  function stopAutoPlay() {
    if (autoPlayInterval) {
      console.log("⏸️ Arrêt auto-play");
      clearInterval(autoPlayInterval);
    }
  }

  // Événements des boutons
  if (prevBtn) {
    prevBtn.addEventListener("click", function () {
      console.log("⬅️ Bouton précédent cliqué");
      stopAutoPlay();
      prevSlide();
      startAutoPlay();
    });
  } else {
    console.error("❌ Bouton précédent non trouvé");
  }

  if (nextBtn) {
    nextBtn.addEventListener("click", function () {
      console.log("➡️ Bouton suivant cliqué");
      stopAutoPlay();
      nextSlide();
      startAutoPlay();
    });
  } else {
    console.error("❌ Bouton suivant non trouvé");
  }

  // Pause au survol
  const picCar = document.getElementById("picCar");
  if (picCar) {
    picCar.addEventListener("mouseenter", stopAutoPlay);
    picCar.addEventListener("mouseleave", startAutoPlay);
  }

  // Créer les indicateurs
  createIndicators();

  // Initialiser la position
  moveCarousel();

  // Démarrer l'auto-play
  startAutoPlay();

  console.log("✅ Carousel flex initialisé avec succès");

  // Debug: vérifier l'état des images
  pictures.forEach((picture, index) => {
    const img = picture.querySelector("img");
    if (img) {
      console.log(`🖼️ Image ${index}: ${img.src}`);

      img.addEventListener("load", function () {
        console.log(`✅ Image ${index} chargée`);
      });

      img.addEventListener("error", function () {
        console.error(`❌ Erreur image ${index}: ${this.src}`);
        // Créer un placeholder
        this.style.backgroundColor = "#333";
        this.style.display = "flex";
        this.style.alignItems = "center";
        this.style.justifyContent = "center";
        this.style.color = "white";
        this.style.fontSize = "16px";
        this.innerHTML = "Image non disponible";
      });
    }
  });
});
