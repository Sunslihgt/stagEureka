<?php
include_once "config.php";

// Démarre la temporisation de sortie
// (Permet de stocker le contenu html suivant dans une variable php)
ob_start();
?>

<main class="main-affichage" id="main-liste-pilotes">
    <form action="wip_liste_pilote_filtre.php" method="post">
        <div class="block-recherche" id="block-recherche-pilotes">
            <div class="barres-recherche">
                <div class="element-recherche" id="pilote-recherche">
                    <label for="nom-pilote-filtre">Nom du pilote</label>
                    <input type="text" placeholder="Recherche via le nom" class="case-recherche" id="nom-pilote-filtre">
                </div>
                <div class="element-recherche" id="localisation-recherche">
                    <label for="prenom-pilote-filtre">Prénom du pilote</label>
                    <input type="text" placeholder="Recherche via le prénom" class="case-recherche" id="prenom-pilote-filtre">
                </div>
            </div>

            <button type="submit" class="bouton-filtrage">Filtrer</button>
        </div>
    </form>

    <div class="affichage-cartes">
        <div class="haut-page-liste-resultats">
            <h1 id="haut-h1">Liste des Pilotes</h1>
            <button id="haut-bouton" onclick="location.href='<?=ADRESSE_SITE?>/pilote/creer'"> Ajouter un Pilote</button>
        </div>

        <div id="selection-pilote">
            <?php foreach ($pilotes as $pilote) { ?>
            
                <div class="carte carte-pilote" id="carte-pilote-<?= $pilote->id ?>">
                    <div class="info-carte">
                        <div class="element-carte">
                            <p class="element-carte-titre">Nom du pilote</p>
                            <p class="element-carte-valeur"><?= $pilote->nom ?></p>
                        </div>
                        <div class="element-carte">
                            <p class="element-carte-titre">Prénom du pilote</p>
                            <p class="element-carte-valeur"><?= $pilote->prenom ?></p>
                        </div>
                        <!-- <div class="element-carte">
                            <p class="element-carte-titre">Classes</p>
                            <p class="element-carte-valeur">Ccccc</p>
                        </div> -->

                        <div class="boutons-carte">
                            <button class="bouton-carte bouton-modification" onclick="location.href='<?=ADRESSE_SITE?>/pilote/modifier/<?= $pilote->id ?>'"><i class="fa-solid fa-pen"></i></button>
                            <span></span>
                            <button class="bouton-carte bouton-suppression" onclick="location.href='<?=ADRESSE_SITE?>/pilote/supprimer/<?= $pilote->id ?>'"><i class="fa-solid fa-trash"></i></button>
                        </div>
                    </div>
                </div>
            <?php } ?>
            
            <!-- Pagination des résultats -->
            <div class="conteneur-pagination-cartes">
                <div class="pagination-cartes" id="pagination">
                    <button class="bouton-nav bouton-minimum"><i class="fa-solid fa-angles-left"></i></button>
                    <button class="bouton-nav bouton-precedent"><i class="fa-solid fa-angle-left"></i></button>
                    <button class="bouton-nav bouton-numero-precedent">1</button>
                    <button class="bouton-nav bouton-numero-actuel">2</button>
                    <button class="bouton-nav bouton-numero-suivant">3</button>
                    <button class="bouton-nav bouton-suivant"><i class="fa-solid fa-angle-right"></i></button>
                    <button class="bouton-nav bouton-extremum"><i class="fa-solid fa-angles-right"></i></button>
                </div>
            </div>
        </div>
    </div>
</main>

<?php
// Stocke le contenu html généré dans une variable php et efface l'html généré précédemment
$contenu = ob_get_clean();

// Déclaration des variables pour la mise en page
$titreOnglet = "Pilotes StagEureka - Trouvez votre stage";
$metaDescription = "Page listant les pilotes du site StagEureka";
$navigationSelectionee = "pilote";
$entetesSuplementaires = "<script src='" . ADRESSE_SITE . "/vue/js/champ_mdp.js'></script>";

// Inclut le template de mise en page
// (Affiche la page avec le contenu html généré précédemment et les variables déclarées ci-dessus)
include "vue/php/mise_en_page.php";
?>