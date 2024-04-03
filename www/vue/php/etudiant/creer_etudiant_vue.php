<?php
include_once "outils.php";

// Démarre la temporisation de sortie
// (Permet de stocker le contenu html suivant dans une variable php)
ob_start();
?>

<main class="main-creation" id="main-creer-etudiant">
    <form action="<?= ADRESSE_SITE ?>/etudiant/creer" method="post">
        <button name="fleche-retour" id="fleche-retour" value="fleche-retour" onclick="location.href='<?= ADRESSE_SITE ?>/etudiant/liste'"><i class="fa-solid fa-arrow-left fa-3x"></i></button>

        <div class="conteneur-creation-etudiant">
            <h1>Création d'un compte étudiant</h1>

            <fieldset class="rectangle-gris">
                <div class="ligne">
                    <div class="colonne">
                        <div class="nom-etudiant">
                            <label for="nom-etudiant">Nom de l'étudiant :</label><br>
                            <input class="case-standard" type="text" name="nom" id="nom-etudiant" required><br><br>
                        </div>

                        <div class="prenom-etudiant">
                            <label for="prenom-etudiant">Prénom de l'étudiant :</label><br>
                            <input class="case-standard" type="text" name="prenom" id="prenom-etudiant" required><br><br>
                        </div>
                    </div>
                    <div class="colonne">
                        <div class="email-etudiant">
                            <label for="email-etudiant">Email :</label><br>
                            <input class="case-standard" type="text" name="email" id="email-etudiant" required><br><br>
                        </div>
                        <div class="mdp-etudiant">
                            <label for="mdp-etudiant">Mot de passe :</label><br>
                            <input class="case-standard" type="text" name="mdp" id="mdp-etudiant"required><br><br>
                        </div>
                    </div>
                    <!-- <div class="colonne">
                        <div class="classe-etudiant">
                            <label for="classe-etudiant">Classe :</label><br>
                            <input class="case-standard" type="text" name="classe" id="classe-etudiant" required><br><br>
                        </div>
                    </div> -->
                </div>

            </fieldset>

            <br>
            <div class="conteneur-bouton-principal">
                <input class="bouton-principal" type="submit" value="Créer un compte étudiant">
            </div>
        </div>

    </form>
</main>

<?php
// Stocke le contenu html généré dans une variable php et efface l'html généré précédemment
$contenu = ob_get_clean();

// Déclaration des variables pour la mise en page
$titreOnglet = "Etudiants StagEureka - Trouvez votre stage";
$metaDescription = "Page de création des étudiants du site StagEureka";
$navigationSelectionee = "etudiants";
// $entetesSuplementaires = "<script src='" . ADRESSE_SITE . "/vue/js/champ_mdp.js'></script>";

// Inclut le template de mise en page
// (Affiche la page avec le contenu html généré précédemment et les variables déclarées ci-dessus)
include "vue/php/mise_en_page_vue.php";

?>