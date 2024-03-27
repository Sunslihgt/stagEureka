// Script pour le filtre en étoile de la wishlist de la page de recherche d'offres (liste_offres.html)
$(document).ready(function() {
    $("#filtre-wishlist").click(function() {
        let etoile = $("#icone-wishlist-filtre");
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