<?php
include_once "outils.php";

// Démarre la temporisation de sortie
// (Permet de stocker le contenu html suivant dans une variable php)
ob_start();
?>

<main class="main-lecture" id="main-lire-etudiant">
    <!-- <form action="<?= ADRESSE_SITE ?>/etudiant/lire/<?= $etudiant->id ?>" method="post"> -->
    <button name="fleche-retour" id="fleche-retour" value="fleche-retour" onclick="location.href='<?= ADRESSE_SITE ?>/etudiant/liste'"><i class="fa-solid fa-arrow-left fa-3x"></i></button>

    <div class="conteneur-modification-etudiant">
        <h1 class="modification-etudiant">Compte étudiant</h1>
        <fieldset class="rectangle-gris">
            <div class="ligne">
                <div class="colonne">
                    <div class="nom-pilote">
                        <label for="nom-etudiant">Nom de l'étudiant :</label><br>
                        <input class="case-standard case-nom-etudiant" type="text" name="nom" id="nom-etudiant" value="<?= $etudiant->nom ?>" disabled><br><br>
                    </div>

                    <div class="prenom-etudiant">
                        <label for="prenom-etudiant">Prénom de l'étudiant :</label><br>
                        <input class="case-standard case-prenom-etudiant" type="text" name="prenom" id="prenom-etudiant" value="<?= $etudiant->prenom ?>" disabled><br><br>
                    </div>
                </div>
                <div class="colonne">
                    <div class="email-etudiant">
                        <label for="email-etudiant">Email :</label><br>
                        <input class="case-standard case-email-etudiant" type="text" name="email" id="email-etudiant" value="<?= $etudiant->email ?>" disabled><br><br>
                    </div>
                    <!-- <div class="mdp-etudiant">
                        <label for="mdp-etudiant">Mot de passe :</label><br>
                        <input class="case-standard case-mdp-etudiant" type="text" name="mdp" id="mdp-etudiant" disabled><br><br>
                    </div> -->

                    <div class="classe-etudiant">
                        <label for="classe-etudiant">Classe :</label><br>
                        <select class="case-standard" name="idClasse" id="classe-etudiant" disabled>
                            <option value="<?= $etudiant->classe->id ?>"><?= $etudiant->classe->nom . " - " . $etudiant->classe->ville ?></option>
                        </select><br><br>
                    </div>
                </div>
            </div>
        </fieldset>

        <!-- <br> -->
        <!-- <div class="conteneur-bouton-principal">
                <input class="bouton-principal" type="submit" value="Modifier le compte étudiant">
            </div> -->

        <!-- <form action="<?= ADRESSE_SITE ?>/etudiant/supprimer/<?= $etudiant->id ?>" method="get">
        <div class="conteneur-bouton-principal bouton-supplementaire">
            <input class="bouton-principal" type="submit" value="Supprimer le compte étudiant">
        </div>
    </form> -->

    </div>
    <!-- </form> -->
</main>

<?php
// Stocke le contenu html généré dans une variable php et efface l'html généré précédemment
$contenu = ob_get_clean();

// Déclaration des variables pour la mise en page
$titreOnglet = "Etudiants StagEureka - Trouvez votre stage";
$metaDescription = "Page de lecture des étudiants du site StagEureka";
$navigationSelectionee = "etudiants";
// $entetesSuplementaires = "<script src='" . ADRESSE_SITE . "/vue/js/champ_mdp.js'></script>";

// Inclut le template de mise en page
// (Affiche la page avec le contenu html généré précédemment et les variables déclarées ci-dessus)
include "vue/php/mise_en_page_vue.php";

?>