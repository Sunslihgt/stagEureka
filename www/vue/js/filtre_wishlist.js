// Script pour le filtre en étoile de la wishlist de la page de recherche d'offres (liste_offres.html)
$(document).ready(function() {
    // Case à cocher du filtre
    const caseFiltre = $("#filtre-wishlist");
    // Icône en étoile du filtre
    const etoile = $("#icone-wishlist-filtre");
    
    // Si la case est cochée, l'étoile est pleine
    caseFiltre.ready(function() {
        // console.log("Chargement filtre wishlist:", caseFiltre.is(":checked"));
        if (caseFiltre.is(":checked")) {
            etoile.removeClass("fa-regular");
            etoile.addClass("fa-solid");
        }
    });
    
    caseFiltre.click(function() {
        // console.log("Filtre wishlist:", caseFiltre.is(":checked"));
        let caseCochee = $(this).is(":checked");
        if (caseCochee) {
            etoile.removeClass("fa-regular");
            etoile.addClass("fa-solid");
        } else {
            etoile.removeClass("fa-solid");
            etoile.addClass("fa-regular");
        }
    });
});