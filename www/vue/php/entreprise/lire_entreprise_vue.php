<?php
include_once "outils.php";

// Démarre la temporisation de sortie
// (Permet de stocker le contenu html suivant dans une variable php)
ob_start();
?>

<main>
    <button name="fleche-retour" id="fleche-retour" value="fleche-retour" onclick="location.href='<?= ADRESSE_SITE ?>/entreprise/liste'">
        <i class="fa-solid fa-arrow-left fa-3x"></i>
    </button>

    <div class="conteneur-entreprise">
        <h1>Entreprise</h1>

        <!-- <form action="<?= ADRESSE_SITE ?>/entreprise/creer" method="post"> -->
        <fieldset class="rectangle-gris">
            <div>
                <label for="entreprise">Nom de l'entreprise :</label><br>
                <input class="case-standard case-nom-ent" type="text" name="entreprise" id="entreprise" value="<?= $entreprise->nom ?>" disabled><br><br>
            </div>

            <!-- <div>
                <label for="numero-rue">Numéro de rue :</label><br>
                <input class="case-standard case-localisation" type="text" name="numeroRue" id="numero-rue" value="" disabled><br><br>
            </div>

            <div>
                <label for="rue">Rue :</label><br>
                <input class="case-standard case-localisation" type="text" name="rue" id="rue" disabled><br><br>
            </div>

            <div>
                <label for="ville">Ville :</label><br>
                <input class="case-standard case-localisation" type="text" name="ville" id="ville" disabled><br><br>
            </div>

            <div>
                <label for="code-postal">Code postal :</label><br>
                <input class="case-standard case-localisation" type="text" name="codePostal" id="code-postal" disabled><br><br>
            </div> -->

            <div>
                <label for="domaine">Domaines :</label><br>
                <input class="case-standard case-domaine" type="text" name="domaine" id="domaine" value="<?= $entreprise->activite ?>" disabled><br><br>
            </div>

            <!-- Affichage des adresses -->
            <?php for ($i = 0; $i < count($entreprise->adresses); $i++) { ?>
                <h3>
                    Adresse <?= $i + 1 ?>
                </h3>
                <p>
                    <?= $entreprise->adresses[$i]->numero . " " . $entreprise->adresses[$i]->rue ?><br>
                    <?= $entreprise->adresses[$i]->codePostal . " " . $entreprise->adresses[$i]->ville ?><br>
                </p><br>
            <?php } ?>

            <!-- <div>
                <label for="entreprise-visible-checkbox">Entreprise visible</label>
                <input type="checkbox" name="visible" id="entreprise-visible-checkbox" <?= $entreprise->visible ? "checked" : "" ?> disabled>
            </div> -->


        </fieldset>

        <?php if (estAdmin() || estPilote()) { ?>
            <form action="<?= ADRESSE_SITE ?>/entreprise/modifier/<?= $entreprise->id ?>" method="get">
                <div class="conteneur-bouton-principal bouton-supplementaire">
                    <input class="bouton-principal" type="submit" value="Modifier l'entreprise">
                </div>
            </form>
            
            <form action="<?= ADRESSE_SITE ?>/entreprise/supprimer/<?= $entreprise->id ?>" method="get">
                <div class="conteneur-bouton-principal bouton-supplementaire">
                    <input class="bouton-principal" type="submit" value="Supprimer l'entreprise">
                </div>
            </form>
        <?php } ?>

        <!-- </form> -->
    </div>
</main>

<?php
// Stocke le contenu html généré dans une variable php et efface l'html généré précédemment
$contenu = ob_get_clean();

// Déclaration des variables pour la mise en page
$titreOnglet = "Entreprise StagEureka - Trouvez votre stage";
$metaDescription = "Page d'une entreprise du site StagEureka";
$navigationSelectionee = "entreprises";
// $entetesSuplementaires = "";

// Inclut le template de mise en page
// (Affiche la page avec le contenu html généré précédemment et les variables déclarées ci-dessus)
include "vue/php/mise_en_page_vue.php";

?>