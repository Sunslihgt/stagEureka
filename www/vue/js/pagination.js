const formulaire = $("form-filtres");

const btnDebut = $("pagination-debut");
const btnNumPrecedent = $("pagination-numero-precedent");
const btnNumActuel = $("pagination-numero-actuel");
const btnNumSuivant = $("pagination-numero-suivant");
const btnFin = $("pagination-fin");

// TODO: Ajouter les événements pour les boutons de pagination
btnDebut.addEventListener("click", function() {
    formulaire.page.value = 1;
    formulaire.submit();
});