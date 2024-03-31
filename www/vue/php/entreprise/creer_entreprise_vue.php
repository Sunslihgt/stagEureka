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
        <h1>Création d'une entreprise</h1>

        <form action="<?= ADRESSE_SITE ?>/entreprise/creer" method="post">
            <fieldset class="rectangle-gris">
                <div>
                    <label for="entreprise">Nom de l'entreprise :</label><br>
                    <input class="case-standard case-nom-ent" type="text" name="entreprise" id="entreprise" required><br><br>
                </div>

                <div>
                    <label for="numero-rue">Numéro de rue :</label><br>
                    <input class="case-standard case-localisation" type="text" name="numeroRue" id="numero-rue" required><br><br>
                </div>

                <div>
                    <label for="rue">Rue :</label><br>
                    <input class="case-standard case-localisation" type="text" name="rue" id="rue" required><br><br>
                </div>

                <div>
                    <label for="ville">Ville :</label><br>
                    <input class="case-standard case-localisation" type="text" name="ville" id="ville" required><br><br>
                </div>

                <div>
                    <label for="code-postal">Code postal :</label><br>
                    <input class="case-standard case-localisation" type="text" name="codePostal" id="code-postal" required><br><br>
                </div>

                <div>
                    <label for="domaine">Domaines :</label><br>
                    <input class="case-standard case-domaine" type="text" name="domaine" id="domaine" required><br><br>
                </div>

                <div>
                    <label for="entreprise-visible-checkbox">Entreprise visible</label>
                    <input type="checkbox" name="visible" id="entreprise-visible-checkbox" checked>
                </div>
            </fieldset>

            <div class="conteneur-bouton-principal">
                <input class="bouton-principal" type="submit" value="Créer une entreprise">
            </div>
        </form>
    </div>
</main>

<?php
// Stocke le contenu html généré dans une variable php et efface l'html généré précédemment
$contenu = ob_get_clean();

// Déclaration des variables pour la mise en page
$titreOnglet = "Créer entreprises StagEureka - Trouvez votre stage";
$metaDescription = "Page de création d'une entreprise du site StagEureka";
$navigationSelectionee = "entreprises";
$entetesSuplementaires = "<script src='" . ADRESSE_SITE . "/vue/js/filtre_etoile.js'></script>";

// Inclut le template de mise en page
// (Affiche la page avec le contenu html généré précédemment et les variables déclarées ci-dessus)
include "vue/php/mise_en_page_vue.php";

?>