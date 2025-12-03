// const fleches = document.querySelectorAll('.fa-solid');
// fleches.forEach(element => {

//  });

const fleches = document.querySelectorAll(".fleche i");
function anime() {
  for (let index = 0; index < fleches.length; index++) {
    setTimeout(function () {
      fleches[index].style.display = "block";
    }, `${index * 600 + 1000}`);
  }
}
window.onload = function () {
  anime();

  setInterval(function () {
    for (let index = 0; index < fleches.length; index++) {
      fleches[index].style.display = "none";
    }
    anime();
  }, 3500);
};

document.addEventListener("DOMContentLoaded", function () {
  // Sélectionner le bouton de défilement
  var scrollButton = document.getElementById("scrollButton");

  // Ajouter un gestionnaire d'événements pour le clic sur le bouton
  scrollButton.addEventListener("click", function (event) {
    // Empêcher le comportement par défaut du lien
    event.preventDefault();

    // Trouver la position de l'élément cible
    var targetElement = document.getElementById("scrollTarget");
    var targetPosition = targetElement.offsetTop;

    // Faire défiler la page jusqu'à l'élément cible
    window.scrollTo({
      top: targetPosition,
      behavior: "smooth", // Faites défiler en douceur
    });
  });
});
