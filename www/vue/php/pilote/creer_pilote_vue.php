<?php
include_once "outils.php";

// Démarre la temporisation de sortie
// (Permet de stocker le contenu html suivant dans une variable php)
ob_start();
?>


<main>
    <button name="fleche-retour" id="fleche-retour" value="fleche-retour" onclick="location.href='<?= ADRESSE_SITE ?>/pilote/liste/'"><i class="fa-solid fa-arrow-left fa-3x"></i></button>

    <div class="conteneur-creation-pilote">
        <h1 class="creation-etudiant">Création d'un compte pilote</h1>
        <form action="<?= ADRESSE_SITE ?>/pilote/creer" method="post">
            <fieldset class="rectangle-gris">
                <div class="ligne">
                    <div class="colonne">
                        <div class="nom-pilote">
                            <label for="nom-pilote">Nom du pilote :</label><br>
                            <input class="case-standard" type="text" name="nom" id="nom-pilote" required><br><br>
                        </div>

                        <div class="prenom-pilote">
                            <label for="prenom-pilote">Prénom du pilote :</label><br>
                            <input class="case-standard" type="text" name="prenom" id="prenom-pilote" required><br><br>
                        </div>
                    </div>
                    <div class="colonne">
                        <div class="email-pilote">
                            <label for="email-pilote">Email :</label><br>
                            <input class="case-standard" type="text" name="email" id="email-pilote" required><br><br>
                        </div>
                        <div class="mdp-pilote">
                            <label for="mdp-pilote">Mot de passe :</label><br>
                            <input class="case-standard" type="text" name="mdp" id="mdp-pilote" required><br><br>
                        </div>
                    </div>
                    <!-- <div class="colonne">
                        <div class="classe-pilote">
                            <label for="classe-pilote">Classes :</label><br>
                            <input class="case-standard" type="text" name="classe" id="classe-pilote" required><br><br>
                        </div>
                    </div> -->
                </div>

            </fieldset>

            <br>
            <div class="conteneur-bouton-principal">
                <input class="bouton-principal" type="submit" value="Créer un compte pilote">
            </div>
        </form>
    </div>
</main>

<?php
// Stocke le contenu html généré dans une variable php et efface l'html généré précédemment
$contenu = ob_get_clean();

// Déclaration des variables pour la mise en page
$titreOnglet = "Pilotes StagEureka - Trouvez votre stage";
$metaDescription = "Page permettant la creation d'un pilote du site StagEureka";
$navigationSelectionee = "pilotes";
$entetesSuplementaires = "<script src='" . ADRESSE_SITE . "/vue/js/champ_mdp.js'></script>";

// Inclut le template de mise en page
// (Affiche la page avec le contenu html généré précédemment et les variables déclarées ci-dessus)
include "vue/php/mise_en_page_vue.php";
?>