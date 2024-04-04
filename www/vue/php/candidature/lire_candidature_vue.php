<?php
include_once "outils.php";

// Démarre la temporisation de sortie
// (Permet de stocker le contenu html suivant dans une variable php)
ob_start();
?>

<main class="main-creation" id="main-creer-candidature">
    <button name="fleche-retour" id="fleche-retour" value="fleche-retour" onclick="location.href='<?= ADRESSE_SITE ?>/offre/liste'"><i class="fa-solid fa-arrow-left fa-3x"></i></button>

    <div class="conteneur-creation-etudiant">
        <h1>Candidature</h1>

        <fieldset class="rectangle-gris">
            <div class="ligne">
                <div class="colonne">
                    <div>
                        <label for="motivation">Lettre de motivation :</label><br>
                        <textarea rows="20" class="case-standard case-candidature" type="text" name="motivation" id="motivation" disabled><?= $candidature->motivation ?></textarea><br><br>
                    </div>

                    <div>
                        <label for="cv">CV (pdf) :</label><br>
                        <!-- <a href="data:application/pdf;base64,<?= base64_encode($candidature->cvFichier) ?>" download="cv.pdf">Télécharger le CV</a> -->
                        <a href="<?= ADRESSE_SITE ?>/fichier/candidature/<?= $candidature->idCandidature ?>">Télécharger le CV</a>
                    </div>
                </div>
            </div>
        </fieldset>

        <br>
        <!-- <form action="<?= ADRESSE_SITE ?>/candidature/supprimer/<?= $candidature->idCandidature ?>" method="post">
            <div class="conteneur-bouton-principal">
                <input class="bouton-principal" type="submit" value="Créer un compte étudiant">
            </div>
        </form><br><br> -->
    </div>
</main>

<?php
// Stocke le contenu html généré dans une variable php et efface l'html généré précédemment
$contenu = ob_get_clean();

// Déclaration des variables pour la mise en page
$titreOnglet = "Lecture d'une candidature à un stage StagEureka - Trouvez votre stage";
$metaDescription = "Page de lecture d'une candidature d'un stage du site StagEureka";
// $navigationSelectionee = "candidatures";
// $entetesSuplementaires = "";

// Inclut le template de mise en page
// (Affiche la page avec le contenu html généré précédemment et les variables déclarées ci-dessus)
include "vue/php/mise_en_page_vue.php";

?>