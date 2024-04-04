<?php
include_once "outils.php";

// Démarre la temporisation de sortie
// (Permet de stocker le contenu html suivant dans une variable php)
ob_start();
?>

<main class="main-affichage" id="main-liste-entreprises">
    <form action="<?= ADRESSE_SITE ?>/entreprise/liste" method="post">
        <div class="block-recherche" id="block-recherche-entreprises">
            <div id="champs-filtre">
                <div class="barres-recherche">
                    <div class="element-recherche" id="entreprise-recherche">
                        <label for="nom-entreprise-filtre">Nom</label>
                        <input type="text" placeholder="Recherche via l'entreprise" class="case-recherche" id="nom-entreprise-filtre" name="nom-entreprise-filtre">
                    </div>
                    <span></span>
                    <div class="element-recherche" id="localisation-recherche">
                        <label for="localisation-filtre">Localisation</label>
                        <input type="text" placeholder="Recherche via localisation" class="case-recherche" id="localisation-filtre" name="localisation-filtre">
                    </div>
                </div>
                <span></span>
                <div class="recherche-etoiles">
                    <div class="element-recherche" id="note-pilotes">
                        <h3>Pilotes</h3>
                        <div class="champ-etoiles" id="etoiles-pilote-filtre">
                            <button type="button" class="etoile" id="filtre-etoile-pilote-1"><i class="fa-solid fa-star"></i></button>
                            <button type="button" class="etoile" id="filtre-etoile-pilote-2"><i class="fa-regular fa-star"></i></button>
                            <button type="button" class="etoile" id="filtre-etoile-pilote-3"><i class="fa-regular fa-star"></i></button>
                            <button type="button" class="etoile" id="filtre-etoile-pilote-4"><i class="fa-regular fa-star"></i></button>
                            <button type="button" class="etoile" id="filtre-etoile-pilote-5"><i class="fa-regular fa-star"></i></button>
                        </div>
                        <input type="hidden" name="note-pilote-filtre" id="note-pilote" value="1">
                    </div>
                    <div class="element-recherche" id="note-etudiants">
                        <h3>Etudiants</h3>
                        <div class="champ-etoiles" id="etoiles-etudiant-filtre">
                            <button type="button" class="etoile" id="filtre-etoile-etudiant-1"><i class="fa-solid fa-star"></i></button>
                            <button type="button" class="etoile" id="filtre-etoile-etudiant-2"><i class="fa-regular fa-star"></i></button>
                            <button type="button" class="etoile" id="filtre-etoile-etudiant-3"><i class="fa-regular fa-star"></i></button>
                            <button type="button" class="etoile" id="filtre-etoile-etudiant-4"><i class="fa-regular fa-star"></i></button>
                            <button type="button" class="etoile" id="filtre-etoile-etudiant-5"><i class="fa-regular fa-star"></i></button>
                        </div>
                        <input type="hidden" name="note-etudiant-filtre" id="note-etudiant" value="1">
                    </div>
                </div>
            </div>

            <button type="reset" class="bouton-filtrage">Effacer</button>
            <button type="submit" class="bouton-filtrage">Filtrer</button>
        </div>

        <?php
        $nbResultats = count($entreprises);
        $nbPages = (int) ceil($nbResultats / NB_RESULTATS_PAGE);
        $page = isset($_POST["page"]) ? intval($_POST["page"]) : 1;
        ?>
        <input type="hidden" name="page" id="page" value="<?= $page ?>">
        <input type="hidden" name="nb-pages" id="nb-pages" value="<?= ceil(count($entreprises) / NB_RESULTATS_PAGE); ?>">
    </form>

    <div class="affichage-cartes">
        <div class="haut-page-liste-resultats">
            <h1 id="haut-h1">Liste des Entreprises</h1>
            <button id="haut-bouton" onclick="location.href='<?= ADRESSE_SITE ?>/entreprise/creer'">Ajouter une Entreprise</button>
        </div>

        <div id="selection-entreprise">
            <?php for ($i = ($page - 1) * NB_RESULTATS_PAGE; $i < min(count($entreprises), $page * NB_RESULTATS_PAGE); $i++) { ?>
                <?php $entreprise = $entreprises[$i] ?>
                <div class="carte carte-entreprise" id="carte-entreprise-<?= $entreprise->id ?>">
                    <div class="info-carte">
                        <div class="element-carte">
                            <p class="element-carte-titre">Nom</p>
                            <p class="element-carte-valeur"><?= $entreprise->nom ?></p>
                        </div>

                        <!-- Villes -->
                        <?php if (count($entreprise->adresses) > 0) { ?>
                            <div class="element-carte">
                                <p class="element-carte-titre">Localisation</p>
                                <?php
                                // Crée un string avec les villes des adresses de l'entreprise séparées par des virgules
                                $villesString = implode(", ", array_map(function ($adresse) {
                                    return $adresse->ville;
                                }, $entreprise->adresses));
                                ?>
                                <p class="element-carte-valeur"><?= $villesString ?></p>
                            </div>
                        <?php } ?>
                        <div class="element-carte">
                            <p class="element-carte-titre">Domaines</p>
                            <p class="element-carte-valeur"><?= $entreprise->activite ?></p>
                        </div>
                        <div class="element-carte div-carte-places">
                            <p class="element-carte-titre">Candidats</p>
                            <p class="element-carte-valeur"><?= $entreprise->nbCandidats ?></p>
                        </div>
                        <div class="element-carte div-carte-note-pilote">
                            <p class="element-carte-titre">Pilotes</p>
                            <p class="etoiles-bleues">
                                <?php if ($entreprise->notePilotes == -1) { ?>
                                    <?php for ($j = 0; $j < 5; $j++) { ?>
                                        <i class="fa-solid fa-star" style="color: grey;"></i>
                                    <?php } ?>
                                <?php } else { ?>
                                    <?php for ($j = 0; $j < 5; $j++) { ?>
                                        <i class="fa-<?= $j < $entreprise->notePilotes ? 'solid' : 'regular' ?> fa-star" title="<?= $entreprise->notePilotes ?>/5"></i>
                                    <?php } ?>
                                <?php } ?>
                            </p>
                        </div>
                        <div class="element-carte div-carte-note-etudiant">
                            <p class="element-carte-titre">Etudiants</p>
                            <p class="etoiles-bleues">
                                <?php if ($entreprise->noteEtudiants == -1) { ?>
                                    <?php for ($j = 0; $j < 5; $j++) { ?>
                                        <i class="fa-solid fa-star" style="color: grey;"></i>
                                    <?php } ?>
                                <?php } else { ?>
                                    <?php for ($j = 0; $j < 5; $j++) { ?>
                                        <i class="fa-<?= $j < $entreprise->noteEtudiants ? 'solid' : 'regular' ?> fa-star" title="<?= $entreprise->noteEtudiants ?>/5"></i>
                                    <?php } ?>
                                <?php } ?>
                            </p>
                        </div>
                        <div class="boutons-carte">
                            <button class="bouton-carte" title="Lire" onclick="location.href='<?= ADRESSE_SITE ?>/entreprise/lire/<?= $entreprise->id ?>'">
                                <i class="fa-solid fa-eye"></i>
                            </button>
                            <?php if (estAdmin() || estPilote()) { ?>
                                <span></span>
                                <button class="bouton-carte" title="Modifier" onclick="location.href='<?= ADRESSE_SITE ?>/entreprise/modifier/<?= $entreprise->id ?>'">
                                    <i class="fa-solid fa-pen"></i>
                                </button>
                                <span></span>
                                <button class="bouton-carte" title="Supprimer" onclick="location.href='<?= ADRESSE_SITE ?>/entreprise/supprimer/<?= $entreprise->id ?>'">
                                    <i class="fa-solid fa-trash"></i>
                                </button>
                            <?php } ?>
                        </div>
                    </div>
                </div>
            <?php } ?>

            <?php if (count($etudiants) == 0) { ?>
                <div class="carte carte-etudiant">
                    <div class="info-carte">
                        <div class="element-partition titre-image-etudiant">
                            <div class="nom-etudiant-titre">Aucun résultat trouvé</div>
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
$titreOnglet = "Entreprises StagEureka - Trouvez votre stage";
$metaDescription = "Page de liste des entreprises du site StagEureka";
$navigationSelectionee = "entreprises";
$entetesSuplementaires = "<script src='" . ADRESSE_SITE . "/vue/js/filtre_etoile.js'></script>" .
    "<script src='" . ADRESSE_SITE . "/vue/js/pagination.js'></script>" .
    "<script src='" . ADRESSE_SITE . "/vue/js/effacer_filtres_liste.js' defer></script>";

// Inclut le template de mise en page
// (Affiche la page avec le contenu html généré précédemment et les variables déclarées ci-dessus)
include "vue/php/mise_en_page_vue.php";

?>