<?php
include_once "config.php";

// Démarre la temporisation de sortie
// (Permet de stocker le contenu html suivant dans une variable php)
ob_start();
?>

<main>
    <div id="conteneur-accueil">
        <div id="accueil-images-div">
            <img src="<?= ADRESSE_SITE ?>/vue/ressources/images/logo_simple_clair_grand.png" alt="Logo StagEureka" class="image-accueil">
        </div>

        <span>

        </span>

        <div id="description-div">
            <h1>Qui sommes nous ?</h1><br>
            <p>
                Etudiants à CESI, nous avons créé ce site pour faciliter la recherche de stage et découvrir le développement web.
                Cette plateforme permet aux pilotes de formation de diffuser des offres de stages.
                Les étudiants peuvent chercher des offres, les ajouter à leur wishlist et même postuler.
                <br>
                Actuellement en seconde année de cycle préparatoire intégré à CESI, nous sommes une équipe de 3 développeurs (Adélie, Killian et Samuel) et nous avons développé ce site en quelques semaines.
                <!-- Le code source est disponible sur GitHub sous license MIT. -->
            </p>
            <div id="accueil-btn-div">
                <button class="bouton-principal">Je trouve mon stage</button>
            </div>
        </div>
    </div>
</main>

<?php
// Stocke le contenu html généré dans une variable php et efface l'html généré précédemment
$contenu = ob_get_clean();

// Déclaration des variables pour la mise en page
$titreOnglet = "Accueil StagEureka - Trouvez votre stage";
$metaDescription = "Page d'accueil du site StagEureka";
$navigationSelectionee = "accueil";

// Inclut le template de mise en page
// (Affiche la page avec le contenu html généré précédemment et les variables déclarées ci-dessus)
include "vue/php/mise_en_page.php";

?>