<?php
include_once "outils.php";

// Démarre la temporisation de sortie
// (Permet de stocker le contenu html suivant dans une variable php)
ob_start();
?>

<main class="main-creation" id="main-creer-candidature">
    <button name="fleche-retour" id="fleche-retour" value="fleche-retour" onclick="location.href='<?= ADRESSE_SITE ?>/offre/liste'"><i class="fa-solid fa-arrow-left fa-3x"></i></button>

    <div class="conteneur-creation-etudiant">
        <h1>Création d'une candidature</h1>

        <form action="<?= ADRESSE_SITE ?>/candidature/creer/<?= $offre->id ?>" method="post" enctype="multipart/form-data">
            <fieldset class="rectangle-gris">
                <div class="ligne">
                    <div class="colonne">
                        <div>
                            <label for="motivation">Lettre de motivation :</label><br>
                            <textarea rows="20" class="case-standard case-candidature" type="text" name="motivation" id="motivation" required></textarea><br><br>
                        </div>

                        <div>
                            <label for="cv">CV (pdf) :</label><br>
                            <input class="case-standard case-candidature" type="file" accept=".pdf" name="cv" id="cv" required><br><br>
                        </div>
                    </div>
                </div>
            </fieldset>

            <br>
            <div class="conteneur-bouton-principal">
                <input class="bouton-principal" type="submit" value="Créer un compte étudiant">
            </div>
        </form>
    </div>
</main>

<?php
// Stocke le contenu html généré dans une variable php et efface l'html généré précédemment
$contenu = ob_get_clean();

// Déclaration des variables pour la mise en page
$titreOnglet = "Candidature à un stage StagEureka - Trouvez votre stage";
$metaDescription = "Page de candidature à un stage du site StagEureka";
// $navigationSelectionee = "candidatures";
// $entetesSuplementaires = "";

// Inclut le template de mise en page
// (Affiche la page avec le contenu html généré précédemment et les variables déclarées ci-dessus)
include "vue/php/mise_en_page_vue.php";

?>