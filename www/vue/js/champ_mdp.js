// Afficher/cacher le mot de passe si l'icone d'oeil est cliqué
$(document).ready(function () {
    $(".icone-mdp").each(function() {  // Pour chaque icone de mot de passe
        $(this).click(function() {
            // console.log($(this));
            if ($(this).hasClass("fa-eye")) {  // Mot de passe caché -> le rendre visible
                $(this).toggleClass("fa-eye fa-eye-slash")
                $(this).parent().find("input").prop("type", "text");
            } else {  // Mot de passe visible -> le cacher
                $(this).toggleClass("fa-eye fa-eye-slash");
                $(this).parent().find("input").prop("type", "password");
            }
        });
    });
});
