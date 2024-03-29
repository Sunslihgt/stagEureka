<?php
include_once "config.php";

// Démarre la temporisation de sortie
// (Permet de stocker le contenu html suivant dans une variable php)
ob_start();
?>

<main>
    <div class="conteneur-connexion">
        <h1>Connexion</h1>

        <form action="<?= ADRESSE_SITE ?>/connexion" method="POST">
            <label for="email">Email :</label><br>
            <input class="case" type="text" placeholder="mon.email@boitemail.fr" name="email" id="email" required><br><br>

            <div id="groupe-mdp">
                <label for="mdp">Mot de passe :</label><br>
                <input class="case mdp" type="password" name="mdp" id="mdp" required><br><br>
                <i class="icone-mdp fa-regular fa-eye"></i>
            </div>

            <input type="submit" class="btn-connexion" value="Se connecter">
        </form>
    </div>
</main>

<?php
// Stocke le contenu html généré dans une variable php et efface l'html généré précédemment
$contenu = ob_get_clean();

// Déclaration des variables pour la mise en page
$titreOnglet = "Connexion StagEureka - Trouvez votre stage";
$metaDescription = "Page de connexion du site StagEureka";
// $navigationSelectionee = "";
$entetesSuplementaires = "<script src='" . ADRESSE_SITE . "/vue/js/champ_mdp.js'></script>";

// Inclut le template de mise en page
// (Affiche la page avec le contenu html généré précédemment et les variables déclarées ci-dessus)
include "vue/php/mise_en_page.php";

?>