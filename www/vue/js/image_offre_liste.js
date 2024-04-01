// Affiche l'image de l'offre si l'URL est valide
$(document).ready(function () {  // Lorsque le document est prêt
    // console.log("document ready", $(this));
    $(".image-offre-liste").each(function() {
        // On nettoie l'URL de l'image pour éviter les attaques XSS
        const imageDiv = $(this);
        url = escapeHtml(imageDiv.attr("src"));
        imageDiv.attr("src", url);
        imageDiv.attr("hidden", true);

        // On vérifie si l'URL de l'image est valide sans requête HEAD
        if (url !== null && url.length > 0) {
            var img = new Image();
            img.onload = function() {
                // Si l'URL est valide, on affiche l'image
                // console.log("Image OK: ", url);
                imageDiv.attr("hidden", false);
            };
            img.onerror = function() {
                // Si l'URL n'est pas valide, on cache l'image
                // console.log("Image KO: ", url);
                imageDiv.attr("hidden", true);
            };
            img.src = url;
        } else {  // Si l'URL est vide, on cache l'image
            // console.log("Image vide: ", url);
        }

        // Envoie d'une requête HEAD pour vérifier si l'URL d'image est valide
        // if (url !== null && url.length > 0) {
        //     // Envoi d'une requête HEAD pour vérifier si l'URL d'image est valide
        //     $.ajax({
        //         url: url,
        //         type: 'HEAD',
        //         success: function () {
        //             // Si l'URL est valide, on affiche l'image
        //             imageDiv.attr("hidden", false);
        //             console.log("Image OK: ", url);
        //         },
        //         error: function () {
        //             // Si l'URL n'est pas valide, on cache l'image
        //             // imageDiv.attr("hidden", true);
        //             console.log("Image KO: ", url);
        //         }
        //     });
        // } else {  // Si l'URL est vide, on cache l'image
        //     // imageDiv.attr("hidden", true);
        //     console.log("Image vide: ", url);
        // }
    })
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
