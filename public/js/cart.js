document.addEventListener("DOMContentLoaded", function () {
  const annulerReservation = document.querySelector(".annul");
  const contactAnnule = document.querySelector(".contact_annule");

  annulerReservation.addEventListener("click", (event) => {
    event.preventDefault(); // Empêcher le comportement par défaut du lien
    annulerReservation.style.visibility = "hidden";
    contactAnnule.style.visibility = "visible";
  });

  contactAnnule.addEventListener("click", (event) => {
    event.preventDefault(); // Empêcher le comportement par défaut du lien
    annulerReservation.style.visibility = "visible";
    contactAnnule.style.visibility = "hidden";
  });
});
