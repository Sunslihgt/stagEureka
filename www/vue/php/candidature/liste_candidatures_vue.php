<?php
include_once "outils.php";

// Démarre la temporisation de sortie
// (Permet de stocker le contenu html suivant dans une variable php)
ob_start();
?>

<main class="main-affichage" id="main-liste-candidatures">
    <form action="<?= ADRESSE_SITE ?>/candidature/liste" method="post" id="form-filtres">
        <div class="block-recherche" id="block-recherche-candidature">
            <div class="barres-recherche">
                <div class="element-recherche">
                    <label for="nom-filtre">Nom de l'étudiant</label>
                    <input type="text" class="case-recherche" id="nom-filtre" name="nom" value="<?= isset($_POST["nom"]) ? $_POST["nom"] : "" ?>">
                </div>
                <div class="element-recherche">
                    <label for="prenom-filtre">Prénom de l'étudiant</label>
                    <input type="text" class="case-recherche" id="prenom-filtre" name="prenom" value="<?= isset($_POST["prenom"]) ? $_POST["prenom"] : "" ?>">
                </div>
                <div class="element-recherche">
                    <label for="offre-filtre">Intitulé du stage</label>
                    <input type="text" class="case-recherche" id="offre-filtre" name="nomOffre" value="<?= isset($_POST["nomOffre"]) ? $_POST["nomOffre"] : "" ?>">
                </div>
            </div>

            <button type="reset" class="bouton-filtrage">Effacer</button>
            <button type="submit" class="bouton-filtrage">Filtrer</button>
        </div>

        <?php
        // $nbResultats = count($candidatures);
        // $nbPages = ceil($nbResultats / 5);
        const NB_RESULTATS_PAGE = 5;
        $page = isset($_POST["page"]) ? intval($_POST["page"]) : 1;
        ?>
        <input type="hidden" name="page" id="page" value="<?= $page ?>">
        <input type="hidden" name="nb-pages" id="nb-pages" value="<?= ceil(count($candidatures) / 5); ?>">
    </form>

    <div class="affichage-cartes">
        <div class="haut-page-liste-resultats">
            <h1 id="haut-h1">Liste des Candidatures</h1>
            <!-- <button id="haut-bouton" onclick="location.href='<?= ADRESSE_SITE ?>/candidature/creer'">Créer une candidature</button> -->
        </div>

        <div id="selection-candidature">
            <?php for ($i = ($page - 1) * NB_RESULTATS_PAGE; $i < min(count($candidatures), $page * NB_RESULTATS_PAGE); $i++) { ?>
                <?php $candidature = $candidatures[$i] ?>
                <div class="carte carte-candidature" id="carte-candidature-<?= $candidature["idCandidature"] ?>">
                    <div class="info-carte">
                        <div class="element-carte">
                            <p class="element-carte-titre">Nom de l'étudiant</p>
                            <p class="element-carte-valeur"><?= $candidature["nom"] ?></p>
                        </div>
                        <div class="element-carte">
                            <p class="element-carte-titre">Prénom de l'étudiant</p>
                            <p class="element-carte-valeur"><?= $candidature["prenom"] ?></p>
                        </div>
                        <div class="element-carte div-carte-campus">
                            <p class="element-carte-titre">Intitulé de l'offre</p>
                            <p class="element-carte-valeur"><?= $candidature["titre"] ?></p>
                        </div>

                        <div class="boutons-carte">
                            <button class="bouton-carte" onclick="location.href='<?= ADRESSE_SITE ?>/candidature/lire/<?= $candidature['idCandidature'] ?>'">
                                <i class="fa-solid fa-eye"></i>
                            </button>
                            <span></span>
                            <button class="bouton-carte" onclick="location.href='<?= ADRESSE_SITE ?>/candidature/supprimer/<?= $candidature['idCandidature'] ?>'">
                                <i class="fa-solid fa-trash"></i>
                            </button>
                        </div>
                    </div>
                </div>
            <?php } ?>

            <?php if (count($candidatures) == 0) { ?>
                <div class="carte carte-candidature">
                    <div class="info-carte">
                        <div class="element-partition">
                            <div class="element-carte-titre">Aucun résultat trouvé</div>
                        </div>
                    </div>
                </div>
            <?php } ?>

            <!-- Pagination des résultats -->
            <div class="conteneur-pagination-cartes">
                <div class="pagination-cartes" id="pagination">
                    <button class="bouton-nav" id="pagination-debut" hidden><i class="fa-solid fa-angles-left"></i></button>
                    <button class="bouton-nav" id="pagination-precedent" hidden><i class="fa-solid fa-angle-left"></i></button>
                    <!-- <button class="bouton-nav" id="pagination-numero-precedent" hidden><?= $page - 1 ?></button> -->
                    <button class="bouton-nav" id="pagination-numero-actuel" hidden><?= $page ?></button>
                    <!-- <button class=" bouton-nav" id="pagination-numero-suivant" hidden><?= $page + 1 ?></button> -->
                    <button class="bouton-nav" id="pagination-suivant" hidden><i class="fa-solid fa-angle-right"></i></button>
                    <button class="bouton-nav" id="pagination-fin" hidden><i class="fa-solid fa-angles-right"></i></button>
                </div>
            </div>
        </div>
    </div>
</main>

<?php
// Stocke le contenu html généré dans une variable php et efface l'html généré précédemment
$contenu = ob_get_clean();

// Déclaration des variables pour la mise en page
$titreOnglet = "Liste candidatures StagEureka - Trouvez votre stage";
$metaDescription = "Page de liste des candidatures des étudiants du site StagEureka";
// $navigationSelectionee = "candidatures";
$entetesSuplementaires = "<script src='" . ADRESSE_SITE . "/vue/js/pagination.js'></script>" .
    "<script src='" . ADRESSE_SITE . "/vue/js/effacer_filtres_liste.js' defer></script>";

// Inclut le template de mise en page
// (Affiche la page avec le contenu html généré précédemment et les variables déclarées ci-dessus)
include "vue/php/mise_en_page_vue.php";

?>