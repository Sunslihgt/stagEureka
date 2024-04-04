// Utilisation de l'API de l'Etat (API Géo) pour récupérer les villes en fonction du code postal
// https://geo.api.gouv.fr/communes?fields=nom&codePostal=" + codePostal + "&format=json&geometry=centre

$("#codePostal").on('input', function () {
    $.ajax({
        url: "https://geo.api.gouv.fr/communes?fields=nom&codePostal=" + $("#codePostal").val() + "&format=json&geometry=centre",
        success: function (data) {
            // console.log(data);

            $.each(data, function (i, objetData) {
                console.log(objetData.nom);
                const nomCommune = objetData.nom;
                $('#ville').append(
                    $("<option></option>").text(nomCommune).val(nomCommune)
                );
            });
        }
        // , error: function (error) {
        //     console.log(error);
        // }
    });
});
