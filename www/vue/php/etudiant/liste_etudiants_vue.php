<?php
include_once "outils.php";

// Démarre la temporisation de sortie
// (Permet de stocker le contenu html suivant dans une variable php)
ob_start();
?>

<main class="main-affichage" id="main-liste-etudiants">
    <form action="<?= ADRESSE_SITE ?>/etudiant/liste" method="post" id="form-filtres">
        <div class="block-recherche" id="block-recherche-etudiants">
            <div class="barres-recherche">
                <div class="element-recherche">
                    <label for="nom-etudiant-filtre">Nom de l'étudiant</label>
                    <input type="text" placeholder="Recherche via le nom" class="case-recherche" id="nom-etudiant-filtre" name="nom" value="<?= isset($_POST["nom"]) ? $_POST["nom"] : "" ?>">
                </div>
                <div class="element-recherche">
                    <label for="prenom-etudiant-filtre">Prénom de l'étudiant</label>
                    <input type="text" placeholder="Recherche via le prénom" class="case-recherche" id="prenom-etudiant-filtre" name="prenom" value="<?= isset($_POST["prenom"]) ? $_POST["prenom"] : "" ?>">
                </div>
                <div class="element-recherche">
                    <label for="campus-etudiant-filtre">Campus de l'étudiant</label>
                    <input type="text" placeholder="Recherche via le campus" class="case-recherche" id="campus-etudiant-filtre" name="ville" value="<?= isset($_POST["ville"]) ? $_POST["ville"] : "" ?>">
                </div>
                <div class="element-recherche">
                    <label for="classe-etudiant-filtre">Classe de l'étudiant</label>
                    <input type="text" placeholder="Recherche via la classe" class="case-recherche" id="classe-etudiant-filtre" name="nomClasse" value="<?= isset($_POST["nomClasse"]) ? $_POST["nomClasse"] : "" ?>">
                </div>
            </div>

            <button type="reset" class="bouton-filtrage">Effacer</button>
            <button type="submit" class="bouton-filtrage">Filtrer</button>
        </div>

        <?php
        $nbResultats = count($etudiants);
        $nbPages = ceil($nbResultats / NB_RESULTATS_PAGE);
        $page = isset($_POST["page"]) ? intval($_POST["page"]) : 1;
        ?>
        <input type="hidden" name="page" id="page" value="<?= $page ?>">
        <input type="hidden" name="nb-pages" id="nb-pages" value="<?= ceil(count($etudiants) / NB_RESULTATS_PAGE); ?>">
    </form>

    <div class="affichage-cartes">
        <div class="haut-page-liste-resultats">
            <h1 id="haut-h1">Liste des Etudiants</h1>
            <button id="haut-bouton" onclick="location.href='<?= ADRESSE_SITE ?>/etudiant/creer'">Ajouter un Etudiant</button>
        </div>

        <div id="selection-etudiant">
            <?php for ($i = ($page - 1) * NB_RESULTATS_PAGE; $i < min(count($etudiants), $page * NB_RESULTATS_PAGE); $i++) { ?>
                <?php $etudiant = $etudiants[$i] ?>
                <div class="carte carte-etudiant" id="carte-etudiant-<?= $etudiant->id ?>">
                    <div class="info-carte">
                        <div class="element-carte">
                            <p class="element-carte-titre">Nom de l'étudiant</p>
                            <p class="element-carte-valeur"><?= $etudiant->nom ?></p>
                        </div>
                        <div class="element-carte">
                            <p class="element-carte-titre">Prénom de l'étudiant</p>
                            <p class="element-carte-valeur"><?= $etudiant->prenom ?></p>
                        </div>
                        <div class="element-carte div-carte-campus">
                            <p class="element-carte-titre">Campus</p>
                            <p class="element-carte-valeur"><?= $etudiant->classe->ville ?></p>
                        </div>
                        <div class="element-carte">
                            <p class="element-carte-titre">Classe</p>
                            <p class="element-carte-valeur"><?= $etudiant->classe->nom ?></p>
                        </div>

                        <div class="boutons-carte">
                            <button class="bouton-carte" title="Lire" onclick="location.href='<?= ADRESSE_SITE ?>/etudiant/lire/<?= $etudiant->id ?>'">
                                <i class="fa-solid fa-eye"></i>
                            </button>
                            <span></span>
                            <button class="bouton-carte" title="Modifier" onclick="location.href='<?= ADRESSE_SITE ?>/etudiant/modifier/<?= $etudiant->id ?>'">
                                <i class="fa-solid fa-pen"></i>
                            </button>
                            <span></span>
                            <button class="bouton-carte" title="Supprimer" onclick="location.href='<?= ADRESSE_SITE ?>/etudiant/supprimer/<?= $etudiant->id ?>'">
                                <i class="fa-solid fa-trash"></i>
                            </button>
                        </div>
                    </div>
                </div>
            <?php } ?>

            <?php if (count($etudiants) == 0) { ?>
                <div class="carte carte-etudiant">
                    <div class="info-carte">
                        <div class="element-partition titre-image-offre">
                            <div class="element-carte-titre">Aucun résultat trouvé</div>
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
$titreOnglet = "Etudiants StagEureka - Trouvez votre stage";
$metaDescription = "Page de liste des étudiants du site StagEureka";
$navigationSelectionee = "etudiants";
$entetesSuplementaires = "<script src='" . ADRESSE_SITE . "/vue/js/pagination.js'></script>" .
    "<script src='" . ADRESSE_SITE . "/vue/js/effacer_filtres_liste.js' defer></script>";

// Inclut le template de mise en page
// (Affiche la page avec le contenu html généré précédemment et les variables déclarées ci-dessus)
include "vue/php/mise_en_page_vue.php";

?>