<?php
include_once "outils.php";

// Démarre la temporisation de sortie
// (Permet de stocker le contenu html suivant dans une variable php)
ob_start();
?>

<main>
    <button name="fleche-retour" id="fleche-retour" value="fleche-retour" onclick="location.href='<?= ADRESSE_SITE ?>/pilote/liste/'"><i class="fa-solid fa-arrow-left fa-3x"></i></button>

    <div class="conteneur-modification-pilote">
        <h1 class="modification-pilote">Compte pilote</h1>

        <fieldset class="rectangle-gris">
            <div class="ligne">
                <div class="colonne">
                    <div class="nom-pilote">
                        <label for="nom-pilote">Nom du pilote :</label><br>
                        <input class="case-standard case-nom-pilote" type="text" name="nom-pilote" id="nom-pilote" value="<?= $pilote->nom ?>" disabled><br><br>
                    </div>

                    <div class="prenom-pilote">
                        <label for="prenom-pilote">Prénom du pilote :</label><br>
                        <input class="case-standard case-prenom-pilote" type="text" name="prenom-pilote" id="prenom-pilote" value="<?= $pilote->prenom ?>" disabled><br><br>
                    </div>
                </div>

                <div class="email-pilote">
                    <label for="email-pilote">Email :</label><br>
                    <input class="case-standard case-email-pilote" type="text" name="email-pilote" id="email-pilote" value="<?= $pilote->email ?>" disabled><br><br>
                </div>
                
                <!-- Classes du pilote -->
                <?php if (count($classes) > 0) { ?>
                <div class="classes-pilote">
                    <label for="email-pilote">Classe(s) :</label><br>
                    <?php
                    // Transforme le tableau de classes en une chaine de caractères séparée par des retours à la ligne
                    $classesString = implode("\n", array_map(function ($classe) {
                        return $classe->nom;
                    }, $classes));
                    $classesString = htmlspecialchars($classesString);  // Evite les attaques XSS
                    ?>
                    <textarea class="case-standard" disabled><?= $classesString ?></textarea>
                </div>
                <?php } ?>

                <!-- <div class="colonne">
                    <div class="mdp-pilote">
                        <label for="mdp-pilote">Mot de passe :</label><br>
                        <input class="case-standard case-mdp-pilote" type="text" name="mdp-pilote" id="mdp-pilote" disabled><br><br>
                    </div>
                </div> -->
            </div>

        </fieldset>
    </div>

</main>

<?php
// Stocke le contenu html généré dans une variable php et efface l'html généré précédemment
$contenu = ob_get_clean();

// Déclaration des variables pour la mise en page
$titreOnglet = "Pilotes StagEureka - Trouvez votre stage";
$metaDescription = "Page permettant la suppression d'un pilote du site StagEureka";
$navigationSelectionee = "pilotes";
// $entetesSuplementaires = "";

// Inclut le template de mise en page
// (Affiche la page avec le contenu html généré précédemment et les variables déclarées ci-dessus)
include "vue/php/mise_en_page_vue.php";
?>