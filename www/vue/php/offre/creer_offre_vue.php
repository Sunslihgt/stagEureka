<?php
include_once "outils.php";

// Démarre la temporisation de sortie
// (Permet de stocker le contenu html suivant dans une variable php)
ob_start();
?>

<main>
    <button name="fleche-retour" id="fleche-retour" value="fleche-retour" onclick="location.href='<?= ADRESSE_SITE ?>/offre/liste'">
        <i class="fa-solid fa-arrow-left fa-3x"></i>
    </button>

    <div class="conteneur-creation-offre">
        <h1>Création d'une offre</h1>
        <form action="<?= ADRESSE_SITE ?>/offre/creer" method="post">
            <fieldset class="rectangle-gris">

                <div class="ligne">
                    <div class="colonne">
                        <div>
                            <label for="titre">Titre de l'annonce :</label><br>
                            <input class="case-standard" type="text" name="titre" required><br><br>
                        </div>

                        <div>
                            <label for="entreprise">Entreprise :</label><br>
                            <select class="case-standard" name="idEntreprise">
                                <option value="-1" default>Choisissez une entreprise</option>
                                <?php foreach ($entreprises as $entreprise) { ?>
                                    <option value="<?= $entreprise->id ?>"><?= $entreprise->nom ?></option>
                                <?php } ?>
                            </select><br><br>
                        </div>

                        <div class="creation-offre-localisation">
                            <label for="localisation">Localisation :</label><br>
                            <input class="case-court" type="number" name="numeroRue" placeholder="N° rue" required>
                            <input class="case-standard" type="text" name="rue" id="champ-rue" placeholder="Rue" required><br>
                            <input class="case-standard" type="text" name="ville" placeholder="Ville" required><br>
                            <input class="case-standard" type="number" name="codePostal" placeholder="Code postal" maxlength="5" required><br><br>
                        </div>

                        <div class="div-label-input-horizontal">
                            <label for="duree">Durée (mois) :</label>
                            <input class="case-court" type="number" name="duree" required>
                        </div>

                        <div class="div-label-input-horizontal">
                            <label for="remuneration">Remunération (€/mois) :</label>
                            <input class="case-court" type="number" name="remuneration" required>
                        </div>
                    </div>

                    <div class="colonne">
                        <h3>Catégorie :</h3>
                        <div class="categories">
                            <input type="radio" name="mineure" class="case-mineure accessibilite-invisible" id="gene" value="GENE" required checked>
                            <label class="label-mineure label-gene" for="gene">GENE</label>

                            <input type="radio" name="mineure" class="case-mineure accessibilite-invisible" id="info" value="INFO" required>
                            <label class="label-mineure label-info" for="info">INFO</label>

                            <input type="radio" name="mineure" class="case-mineure accessibilite-invisible" id="btp" value="BTP" required>
                            <label class="label-mineure label-btp" for="btp">BTP</label>

                            <input type="radio" name="mineure" class="case-mineure accessibilite-invisible" id="s3e" value="S3E" required>
                            <label class="label-mineure label-s3e" for="s3e">S3E</label>
                        </div>

                        <div class="place div-label-input-horizontal">
                            <label for="place">Places disponibles :</label>
                            <input class="case-court" type="number" name="place" id="place" required>
                        </div>

                        <div class="url">
                            <h3>URL de l'image :</h3>
                            <input type="text" name="URL" class="case-standard" id="url-image" required><br><br>
                        </div>

                        <div class="competences">
                            <label for="competences">Compétences attendues :</label><br>
                            <textarea class="case-standard" name="competences" id="competences" rows="3"></textarea><br><br>
                        </div>
                    </div>

                    <div class="colonne">
                        <fieldset id="espace-image-offre">
                            <img id="image-offre" alt="Image de l'offre" src="images/logo_simple_clair_grand.png" hidden>
                        </fieldset>
                    </div>
                </div>

                <div class="description">
                    <label for="description">Description :</label>
                    <textarea class="case-description" name="description" id="description" rows="25"></textarea><br><br>
                </div>
            </fieldset>

            <div class="conteneur-bouton-principal">
                <input class="bouton-principal" type="submit" value="Créer une offre">
            </div>
        </form>
    </div>
</main>

<?php
// Stocke le contenu html généré dans une variable php et efface l'html généré précédemment
$contenu = ob_get_clean();

// Déclaration des variables pour la mise en page
$titreOnglet = "Créer offre de stage StagEureka - Trouvez votre stage";
$metaDescription = "Page de création d'offre de stage du site StagEureka";
$navigationSelectionee = "offres";
$entetesSuplementaires = "<script src='" . ADRESSE_SITE . "/vue/js/image_offre_creation_modification.js' defer></script>";

// Inclut le template de mise en page
// (Affiche la page avec le contenu html généré précédemment et les variables déclarées ci-dessus)
include "vue/php/mise_en_page_vue.php";

?>