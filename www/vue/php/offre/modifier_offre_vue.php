<?php
include_once "outils.php";

// Démarre la temporisation de sortie
// (Permet de stocker le contenu html suivant dans une variable php)
ob_start();
?>

<main class="main-affichage" id="main-liste-offres">
</main>

<?php
// Stocke le contenu html généré dans une variable php et efface l'html généré précédemment
$contenu = ob_get_clean();

// Déclaration des variables pour la mise en page
$titreOnglet = "Modifier offre de stage StagEureka - Trouvez votre stage";
$metaDescription = "Page de modification d'offre de stage du site StagEureka";
$navigationSelectionee = "offres";
$entetesSuplementaires = "<script src='" . ADRESSE_SITE . "/vue/js/image_offre_creation_modification.js' defer></script>";

// Inclut le template de mise en page
// (Affiche la page avec le contenu html généré précédemment et les variables déclarées ci-dessus)
include "vue/php/mise_en_page_vue.php";

?>