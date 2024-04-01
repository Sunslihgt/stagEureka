// Affiche l'image de l'offre si l'URL est valide
$(document).ready(function () {  // Lorsque le document est prêt
    // console.log("document ready", $(this));
    $("#url-image").change(function() {  // Lorsque le champ de l'URL de l'image change
        // On récupère l'URL de l'image et on la nettoie pour éviter les attaques XSS
        const url = escapeHtml($(this).val());
        const imageDiv = $("#image-offre");
        if (url !== null && url.length > 0) {
            // Envoi d'une requête HEAD pour vérifier si l'URL d'image est valide
            $.ajax({
                url: url,
                type: 'HEAD',
                success: function () {
                    // Si l'URL est valide, on affiche l'image
                    imageDiv.attr("src", url);
                    imageDiv.show();
                },
                error: function () {
                    // Si l'URL n'est pas valide, on cache l'image
                    imageDiv.attr("src", "");
                    imageDiv.hide();
                }
            });
        } else {  // Si l'URL est vide, on cache l'image
            imageDiv.attr("src", "");
            imageDiv.hide();
        }
    });
});

// Netttoie le texte pour éviter les attaques XSS
// (Permet de protéger les urls, source=https://stackoverflow.com/a/4835406)
function escapeHtml(text) {
    var map = {
        '&': '&amp;',
        '<': '&lt;',
        '>': '&gt;',
        '"': '&quot;',
        "'": '&#039;'
    };

    return text.replace(/[&<>"']/g, function (m) {
        return map[m];
    });
}
