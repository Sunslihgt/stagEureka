// Script pour ajouter/supprimer une offre à la wishlist depuis la liste des offres

$(document).ready(function() {
    $(".checkboxes-wishlist").click(function() {
        // console.log("Clic sur une checkbox wishlist", $(this).attr("id"));
        const idOffre = parseInt($(this).attr("id").split("-")[2]);
        // console.log("idOffre:", idOffre);

        // On récupère l'état de la checkbox avant le clic
        let coche = !$(this).is(":checked");  // (true si pas coché, false si coché)
        $(this).prop('checked', coche);  // On inverse l'état de la checkbox pour annuler le click
        console.log("coche:", coche);

        if (coche) {  // On veut supprimer de la wishlist
            console.log("On veut supprimer l'offre " + idOffre + " de la wishlist");
            retirerOffreWishlist(idOffre);
        } else {  // On veut ajouter à la wishlist
            console.log("On veut ajouter l'offre " + idOffre + " à la wishlist");
            ajouterOffreWishlist(idOffre);
        }
    });
});

function callbackOffreWishlist(idOffre, action, reussite) {
    // console.log("callbackOffreWishlist", idOffre, action, reussite);
    if (action === "ajouter") {
        if (reussite) {
            // console.log("Offre ajoutée à la wishlist, changement de l'icône de la checkbox");
            // On change l'icône de la checkbox
            const idCheckbox = "checkbox-wishlist-" + idOffre;
            $("#" + idCheckbox).prop("checked", true);  // On coche la checkbox
            const label = $("#label-checkbox-wishlist-" + idOffre + " i");
            label.addClass("fa-solid");
            label.removeClass("fa-regular");
        }
    } else if (action === "supprimer") {
        if (reussite) {
            // console.log("Offre retirée de la wishlist, changement de l'icône de la checkbox");
            // On change l'icône de la checkbox
            const idCheckbox = "checkbox-wishlist-" + idOffre;
            $("#" + idCheckbox).prop("checked", false);  // On coche la checkbox
            const label = $("#label-checkbox-wishlist-" + idOffre + " i");
            label.addClass("fa-regular");
            label.removeClass("fa-solid");
        }
    }
}

// Requête AJAX pour ajouter une offre à la wishlist
function ajouterOffreWishlist(idOffre) {
    // console.log("Ajout de l'offre " + idOffre + " à la wishlist");
    
    const url = window.location.href.replace("offre/liste", "wishlist/ajouter/" + idOffre)
    console.log("Requête ajax vers:", url);
    $.ajax({
        url: url,
        type: 'GET',
        success: function (data, textStatus, xhr) {
            callbackOffreWishlist(idOffre, "ajouter", true);
        },
        error: function (xhr, textStatus, erreur) {
            callbackOffreWishlist(idOffre, "ajouter", false);
        }
    });
}

// Requête AJAX pour supprimer une offre à la wishlist
function retirerOffreWishlist(idOffre) {
    console.log("Retrait de l'offre " + idOffre + " de la wishlist");
    
    const url = window.location.href.replace("offre/liste", "wishlist/supprimer/" + idOffre)
    console.log("Requête ajax vers:", url);
    $.ajax({
        url: url,
        type: 'DELETE',
        success: function (data, textStatus, xhr) {
            callbackOffreWishlist(idOffre, "supprimer", true);
        },
        error: function (xhr, textStatus, erreur) {
            console.log(erreur);
            callbackOffreWishlist(idOffre, "supprimer", false);
        }
    });
}