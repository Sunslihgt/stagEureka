<?php
include_once "outils.php";

// Démarre la temporisation de sortie
// (Permet de stocker le contenu html suivant dans une variable php)
ob_start();
?>

<main>
    <div id="conteneur-infos-legales">
        <h3>Contact</h3>
        <p>
            Contact :<br>
            cesi.sn.aks@protonmail.com
        </p>
        <br>

        <h3>Informations légales</h3>

        <p>
            StagEureka 2024<br>
            Cookies fonctionnels uniquement
        </p>

        <p>
            Hébergement :<br>
            <a href="https://www.alwaysdata.com">Alwaysdata</a><br>
            91 rue du Faubourg Saint Honoré - 75008 Paris
        </p>
    </div>
</main>

<?php
// Stocke le contenu html généré dans une variable php et efface l'html généré précédemment
$contenu = ob_get_clean();

// Déclaration des variables pour la mise en page
$titreOnglet = "Informations légales StagEureka - Trouvez votre stage";
$metaDescription = "Page d'informations légales et de contact du site StagEureka";
// $navigationSelectionee = "";

// Inclut le template de mise en page
// (Affiche la page avec le contenu html généré précédemment et les variables déclarées ci-dessus)
include "vue/php/mise_en_page_vue.php";

?>