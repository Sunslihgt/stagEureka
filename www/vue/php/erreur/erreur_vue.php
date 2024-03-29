<?php
// include_once "config.php";

// Démarre la temporisation de sortie
// (Permet de stocker le contenu html suivant dans une variable php)
ob_start();
?>

<main>
    <div class="message-erreur">
        <h1 id="erreur">Erreur <?= $codeErreur ?></h1>
        
        <h3><?= $messageErreur ?? "Une erreur inattendue est survenue" ?></h3>
        <span></span><!-- Espace vide pour aérer la page -->
        
        <a href="accueil.html" class="bouton-principal">Retour à l'accueil</a>
    </div>
</main>

<?php
// Stocke le contenu html généré dans une variable php et efface l'html généré précédemment
$contenu = ob_get_clean();

// Déclaration des variables pour la mise en page
$titreOnglet = "Erreur " . $codeErreur . " StagEureka - Trouvez votre stage";
$metaDescription = "Page d'erreur " . $codeErreur . " du site StagEureka";
// $navigationSelectionee = "";

// Inclut le template de mise en page
// (Affiche la page avec le contenu html généré précédemment et les variables déclarées ci-dessus)
include "vue/php/mise_en_page.php";

?>