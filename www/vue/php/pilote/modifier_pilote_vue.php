<?php
include_once "config.php";

// Démarre la temporisation de sortie
// (Permet de stocker le contenu html suivant dans une variable php)
ob_start();
?>

<main class="main-modification" id="main-modifier-pilote">
    <form action="<?= ADRESSE_SITE ?>/pilote/modifier/<?= $pilote->id ?>" method="post">
        <button name="fleche-retour" id="fleche-retour" value="fleche-retour" onclick="location.href='<?= ADRESSE_SITE ?>/pilote/liste/'"><i class="fa-solid fa-arrow-left fa-3x"></i></button>

        <div class="conteneur-modification-pilote">
            <h1 class="modification-pilote">Modification d'un compte pilote</h1>
            <fieldset class="rectangle-gris">
                <div class="ligne">
                    <div class="colonne">
                        <div class="nom-pilote">
                            <label for="nom-pilote">Nom du pilote :</label><br>
                            <input class="case-standard case-nom-pilote" type="text" name="nom-pilote" id="nom-pilote" value="<?= $pilote->nom ?>" required><br><br>
                        </div>

                        <div class="prenom-pilote">
                            <label for="prenom-pilote">Prénom du pilote :</label><br>
                            <input class="case-standard case-prenom-pilote" type="text" name="prenom-pilote" id="prenom-pilote" value="<?= $pilote->prenom ?>" required><br><br>
                        </div>
                    </div>
                    <div class="colonne">
                        <div class="email-pilote">
                            <label for="email-pilote">Email :</label><br>
                            <input class="case-standard case-email-pilote" type="text" name="email-pilote" id="email-pilote" value="<?= $pilote->email ?>" required><br><br>
                        </div>
                        <div class="mdp-pilote">
                            <label for="mdp-pilote">Mot de passe :</label><br>
                            <input class="case-standard case-mdp-pilote" type="text" name="mdp-pilote" id="mdp-pilote" required><br><br>
                        </div>
                    </div>
                    <!-- <div class="colonne">
                        <div class="classe-pilote">
                            <label for="classe-pilote">Classes :</label><br>
                            <input class="case-standard case-classe-pilote" type="text" name="classe-pilote" id="classe-pilote" required><br><br>
                        </div>
                    </div> -->
                </div>

            </fieldset>


            <br>
            <div class="conteneur-bouton-principal">
                <input class="bouton-principal" type="submit" value="Modifier le compte pilote">
            </div>
        </div>
    </form>
</main>

<?php
// Stocke le contenu html généré dans une variable php et efface l'html généré précédemment
$contenu = ob_get_clean();

// Déclaration des variables pour la mise en page
$titreOnglet = "Pilotes StagEureka - Trouvez votre stage";
$metaDescription = "Page permettant la modification d'un pilote du site StagEureka";
$navigationSelectionee = "pilote";
$entetesSuplementaires = "<script src='" . ADRESSE_SITE . "/vue/js/champ_mdp.js'></script>";

// Inclut le template de mise en page
// (Affiche la page avec le contenu html généré précédemment et les variables déclarées ci-dessus)
include "vue/php/mise_en_page.php";
?>