<?php
include_once "outils.php";

// Démarre la temporisation de sortie
// (Permet de stocker le contenu html suivant dans une variable php)
ob_start();
?>

<main class="main-affichage" id="main-liste-pilotes">
    <form action="<?= ADRESSE_SITE ?>/pilote/liste" method="post" id="form-filtres">
        <div class="block-recherche" id="block-recherche-pilotes">
            <div class="barres-recherche">
                <div class="element-recherche" id="pilote-recherche">
                    <label for="nom">Nom du pilote</label>
                    <input type="text" placeholder="Recherche via le nom" class="case-recherche" id="nom" name="nom" value="<?= isset($_POST["nom"]) ? $_POST["nom"] : "" ?>">
                </div>
                <div class="element-recherche" id="localisation-recherche">
                    <label for="prenom">Prénom du pilote</label>
                    <input type="text" placeholder="Recherche via le prénom" class="case-recherche" id="prenom" name="prenom" value="<?= isset($_POST["prenom"]) ? $_POST["prenom"] : "" ?>">
                </div>
            </div>

            <button type="reset" class="bouton-filtrage">Effacer</button>
            <button type="submit" class="bouton-filtrage">Filtrer</button>
        </div>

        <?php
        $nbResultats = count($pilotes);
        $nbPages = ceil($nbResultats / NB_RESULTATS_PAGE);
        $page = isset($_POST["page"]) ? intval($_POST["page"]) : 1;
        ?>
        <input type="hidden" name="page" id="page" value="<?= $page ?>">
        <input type="hidden" name="nb-pages" id="nb-pages" value="<?= ceil(count($pilotes) / NB_RESULTATS_PAGE); ?>">
    </form>

    <div class="affichage-cartes">
        <div class="haut-page-liste-resultats">
            <h1 id="haut-h1">Liste des Pilotes</h1>
            <button id="haut-bouton" onclick="location.href='<?= ADRESSE_SITE ?>/pilote/creer'"> Ajouter un Pilote</button>
        </div>

        <div id="selection-pilote">
            <?php for ($i = ($page - 1) * NB_RESULTATS_PAGE; $i < min(count($pilotes), $page * NB_RESULTATS_PAGE); $i++) { ?>
                <?php $pilote = $pilotes[$i] ?>
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
                            <button class="bouton-carte" title="Lire" onclick="location.href='<?= ADRESSE_SITE ?>/pilote/lire/<?= $pilote->id ?>'">
                                <i class="fa-solid fa-eye"></i>
                            </button>
                            <span></span>
                            <button class="bouton-carte" title="Modifier" onclick="location.href='<?= ADRESSE_SITE ?>/pilote/modifier/<?= $pilote->id ?>'">
                                <i class="fa-solid fa-pen"></i>
                            </button>
                            <span></span>
                            <button class="bouton-carte" title="Supprimer" onclick="location.href='<?= ADRESSE_SITE ?>/pilote/supprimer/<?= $pilote->id ?>'">
                                <i class="fa-solid fa-trash"></i>
                            </button>
                        </div>
                    </div>
                </div>
            <?php } ?>

            <!-- Pagination des résultats -->
            <div class="conteneur-pagination-cartes">
                <div class="pagination-cartes" id="pagination">
                    <button class="bouton-nav" title="Page début" id="pagination-debut" hidden><i class="fa-solid fa-angles-left"></i></button>
                    <button class="bouton-nav" title="Page précédent" id="pagination-precedent" hidden><i class="fa-solid fa-angle-left"></i></button>
                    <!-- <button class="bouton-nav" title="Page précédent" id="pagination-numero-precedent" hidden><?= $page - 1 ?></button> -->
                    <button class="bouton-nav" title="Page actuelle" id="pagination-numero-actuel" hidden><?= $page ?> / <?= $nbPages ?></button>
                    <!-- <button class=" bouton-nav" title="Page suivante" id="pagination-numero-suivant" hidden><?= $page + 1 ?></button> -->
                    <button class="bouton-nav" title="Page suivante" id="pagination-suivant" hidden><i class="fa-solid fa-angle-right"></i></button>
                    <button class="bouton-nav" title="Page fin" id="pagination-fin" hidden><i class="fa-solid fa-angles-right"></i></button>
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
$navigationSelectionee = "pilotes";
$entetesSuplementaires = "<script src='" . ADRESSE_SITE . "/vue/js/pagination.js'></script>" .
    "<script src='" . ADRESSE_SITE . "/vue/js/effacer_filtres_liste.js' defer></script>";

// Inclut le template de mise en page
// (Affiche la page avec le contenu html généré précédemment et les variables déclarées ci-dessus)
include "vue/php/mise_en_page_vue.php";
?>