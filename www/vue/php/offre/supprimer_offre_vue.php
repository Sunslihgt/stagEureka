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
        <h1>Suppression d'une offre</h1>

        <form action="<?= ADRESSE_SITE ?>/offre/supprimer/<?= $offre->id ?>" method="post">
            <fieldset class="rectangle-gris">
                <div class="ligne">
                    <div class="colonne">
                        <div>
                            <label for="titre">Titre de l'annonce :</label><br>
                            <input class="case-standard" type="text" name="titre" id="titre" value="<?= $offre->titre ?>" disabled><br><br>
                        </div>

                        <div>
                            <label for="id-entreprise">Entreprise :</label><br>
                            <select class="case-standard" name="idEntreprise" id="id-entreprise" disabled>
                                <option value="<?= $offre->entreprise->id ?>" default>
                                    <?= $offre->entreprise->nom ?>
                                </option>
                            </select><br><br>
                        </div>

                        <div class="creation-offre-localisation">
                            <h3>Localisation :</h3>
                            <input class="case-court" type="number" name="numeroRue" placeholder="N° rue" value="<?= $offre->adresse->numero ?>" disabled>
                            <input class="case-standard" type="text" name="rue" id="champ-rue" placeholder="Rue" value="<?= $offre->adresse->rue ?>" disabled><br>
                            <input class="case-standard" type="text" name="ville" placeholder="Ville" value="<?= $offre->adresse->ville ?>" disabled><br>
                            <input class="case-standard" type="number" name="codePostal" placeholder="Code postal" maxlength="5" value="<?= $offre->adresse->codePostal ?>" disabled><br><br>
                        </div>

                        <div class="div-label-input-horizontal">
                            <label for="duree">Durée (mois) :</label>
                            <input class="case-court" type="number" name="duree" id="duree" value="<?= $offre->duree ?>" disabled>
                        </div>

                        <div class="div-label-input-horizontal">
                            <label for="remuneration">Remunération (€/mois) :</label>
                            <input class="case-court" type="number" name="remuneration" id="remuneration" value="<?= $offre->remuneration ?>" disabled>
                        </div>
                    </div>

                    <div class="colonne">
                        <h3>Catégorie :</h3>
                        <div class="categories">
                            <input type="radio" name="mineure" class="case-mineure accessibilite-invisible" id="gene" value="GENE" <?= $offre->mineure == "GENE" ? "checked" : "" ?> disabled>
                            <label class="label-mineure label-gene" for="gene">GENE</label>

                            <input type="radio" name="mineure" class="case-mineure accessibilite-invisible" id="info" value="INFO" <?= $offre->mineure == "INFO" ? "checked" : "" ?> disabled>
                            <label class="label-mineure label-info" for="info">INFO</label>

                            <input type="radio" name="mineure" class="case-mineure accessibilite-invisible" id="btp" value="BTP" <?= $offre->mineure == "BTP" ? "checked" : "" ?> disabled>
                            <label class="label-mineure label-btp" for="btp">BTP</label>

                            <input type="radio" name="mineure" class="case-mineure accessibilite-invisible" id="s3e" value="S3E" <?= $offre->mineure == "S3E" ? "checked" : "" ?> disabled>
                            <label class="label-mineure label-s3e" for="s3e">S3E</label>
                        </div>

                        <div class="place div-label-input-horizontal">
                            <label for="place">Places disponibles :</label>
                            <input class="case-court" type="number" name="place" id="place" value="<?= $offre->places ?>" disabled>
                        </div>

                        <div class="url">
                            <h3>URL de l'image :</h3>
                            <input type="text" name="URL" class="case-standard" id="url-image" value="<?= $offre->urlImage ?>" disabled><br><br>
                        </div>

                        <div class="competences">
                            <label for="competences">Compétences attendues :</label><br>
                            <textarea class="case-standard" name="competences" id="competences" rows="3" disabled><?= $offre->competences ?></textarea><br><br>
                        </div>
                    </div>

                    <div class="colonne">
                        <fieldset id="espace-image-offre">
                            <img id="image-offre" alt="Image de l'offre" src="<?= $offre->urlImage ?>" hidden>
                        </fieldset>
                    </div>
                </div>

                <div class="description">
                    <label for="description">Description :</label>
                    <textarea class="case-description" name="description" id="description" rows="25" disabled><?= $offre->description ?></textarea><br><br>
                </div>
            </fieldset>

            <div class="conteneur-bouton-principal">
                <input class="bouton-principal" type="submit" value="Supprimer une offre">
            </div>

            <input type="hidden" name="confirmation" value="oui">
        </form>

        <?php if (estAdmin() || estPilote()) { ?>
            <form action="<?= ADRESSE_SITE ?>/offre/modifier/<?= $offre->id ?>" method="get">
                <div class="conteneur-bouton-principal bouton-supplementaire">
                    <input class="bouton-principal" type="submit" value="Modifier l'offre">
                </div>
            </form>

            <form action="<?= ADRESSE_SITE ?>/offre/supprimer/<?= $offre->id ?>" method="get">
                <div class="conteneur-bouton-principal bouton-supplementaire">
                    <input class="bouton-principal" type="submit" value="Supprimer l'offre">
                </div>
            </form>
        <?php } ?>
    </div>
</main>

<?php
// Stocke le contenu html généré dans une variable php et efface l'html généré précédemment
$contenu = ob_get_clean();

// Déclaration des variables pour la mise en page
$titreOnglet = "Offre de stage StagEureka - Trouvez votre stage";
$metaDescription = "Page d'offre de stage du site StagEureka";
$navigationSelectionee = "offres";
$entetesSuplementaires = "<script src='" . ADRESSE_SITE . "/vue/js/image_offre_creation_modification.js' defer></script>";

// Inclut le template de mise en page
// (Affiche la page avec le contenu html généré précédemment et les variables déclarées ci-dessus)
include "vue/php/mise_en_page_vue.php";

?>