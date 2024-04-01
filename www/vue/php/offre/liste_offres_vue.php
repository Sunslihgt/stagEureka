<?php
include_once "outils.php";

// Démarre la temporisation de sortie
// (Permet de stocker le contenu html suivant dans une variable php)
ob_start();
?>

<main class="main-affichage" id="main-liste-offres">
    <form action="wip_liste_offre_filtre.php" method="post">
        <div class="block-recherche" id="block-recherche-offres">
            <div class="barres-recherche">
                <div>
                    <div class="element-recherche">
                        <label for="filtre-nom-offre">Nom de l'offre</label>
                        <input type="text" placeholder="Recherche via le nom" class="case-recherche" id="filtre-nom-offre">
                    </div>
                    <div class="element-recherche" id="localisation-recherche">
                        <h3>Localisation</h3>
                        <div id="conteneur-localisation-filtre">
                            <input type="number" placeholder="Numéro" class="case-recherche" id="filtre-localisation-num">
                            <input type="text" placeholder="Rue" class="case-recherche" id="filtre-localisation-rue">
                            <input type="text" placeholder="Ville" class="case-recherche" id="filtre-localisation-ville">
                        </div>
                    </div>
                </div>
                <span></span>
                <div>
                    <div class="element-recherche" id="duree-recherche">
                        <h3>Durée (mois)</h3>
                        <div id="conteneur-duree-filtre">
                            <input type="number" class="case-court" placeholder="Minimum">
                            &lt; <!-- Symbole plus "petit que" entre le minimum et maximum -->
                            <input type="number" class="case-court" placeholder="Maximum">
                        </div>
                    </div>
                    <div class="element-recherche" id="remuneration-recherche">
                        <h3>Rémunération (€/mois)</h3>
                        <div id="conteneur-remuneration-filtre">
                            <input type="number" class="case-court" placeholder="Minimum">
                            &lt; <!-- Symbole plus "petit que" entre le minimum et maximum -->
                            <input type="number" class="case-court" placeholder="Maximum">
                        </div>
                    </div>
                    <div class="element-recherche" id="wishlist">
                        <h3>Wishlist</h3>
                        <!-- TODO: Cacher ce filtre si l'utilisateur n'est pas un étudiant -->
                        <div id="conteneur-wishlist-filtre">
                            <input type="checkbox" name="wishlist" class="case-wishlist accessibilite-invisible" id="filtre-wishlist">
                            <label class="label-wishlist" for="filtre-wishlist"><i class="fa-regular fa-star" id="icone-wishlist-filtre"></i></label>
                        </div>
                    </div>
                </div>
            </div>
            <div class="mineures-recherche">
                <div class="element-recherche" id="options">
                    <h3>Mineure</h3>
                    <div id="block-mineure"><!-- Choix de mineure(s) (checkbox)-->
                        <input type="checkbox" name="mineure" class="case-mineure accessibilite-invisible" id="gene" value="GENE" checked>
                        <label class="label-mineure label-gene" for="gene">GENE</label>

                        <input type="checkbox" name="mineur" class="case-mineure accessibilite-invisible" id="info" value="INFO" checked>
                        <label class="label-mineure label-info" for="info">INFO</label>

                        <input type="checkbox" name="mineur" class="case-mineure accessibilite-invisible" id="btp" value="BTP" checked>
                        <label class="label-mineure label-btp" for="btp">BTP</label>

                        <input type="checkbox" name="mineur" class="case-mineure accessibilite-invisible" id="s3e" value="S3E" checked>
                        <label class="label-mineure label-s3e" for="s3e">S3E</label>
                    </div>
                </div>
            </div>

            <button type="submit" class="bouton-filtrage">Filtrer</button>
        </div>
    </form>

    <div class="affichage-cartes">
        <div class="haut-page-liste-resultats">
            <h1 id="haut-h1">Liste des Offres</h1>
            <button id="haut-bouton" onclick="location.href='<?= ADRESSE_SITE ?>/offre/creer'">Ajouter une Offre</button>
        </div>

        <div id="selection-entreprise">
            <?php foreach ($offres as $offre) { ?>
                <div class="carte carte-offre" id="carte-offre-<?= $offre->id ?>">
                    <div class="info-carte">
                        <div class="element-partition titre-image-offre">
                            <div class="nom-offre-titre"><?= $offre->titre ?></div>
                            <fieldset class="fieldset-image-offre">
                                <!-- On vérifie que l'url corresponde bien à une image -->
                                <?php if (isset($offre->urlImage) && (preg_match('/\.(png|jpg|jpeg|webp|svg|gif|bmp)$/', strtolower($offre->urlImage)))) { ?>
                                    <img src="<?= $offre->urlImage ?> " alt="Image de l'offre" class="image-offre-liste" hidden>
                                <?php } ?>
                            </fieldset>
                        </div>

                        <div class="contenu-offre">
                            <div class="element-partition">
                                <div class="element-carte">
                                    <p class="element-carte-titre">Entreprise</p>
                                    <p class="element-carte-valeur"><?= $offre->entreprise->nom ?></p>
                                </div>
                                <div class="element-carte">
                                    <p class="element-carte-titre">Localisation</p>
                                    <p class="element-carte-valeur"><?= $offre->adresse->ville ?></p>
                                </div>
                                <div class="element-carte">
                                    <p class="element-carte-titre">Durée</p>
                                    <p class="element-carte-valeur"><?= $offre->duree ?> mois</p>
                                </div>
                                <div class="element-carte">
                                    <p class="element-carte-titre">Publication</p>
                                    <p class="element-carte-valeur"><?= $offre->dateDebut->format("d/m/Y") ?></p>
                                </div>
                            </div>

                            <div class="element-partition">
                                <div class="element-carte">
                                    <p class="element-carte-titre">Compétences</p>
                                    <p class="element-carte-valeur"><?= $offre->competences ?></p>
                                </div>

                                <div class="element-carte">
                                    <p class="element-carte-titre">Catégorie</p>
                                    <div class="carte-mineure-offre">
                                        <h3 class="label-mineure label-mineure-offre carte-<?= strtolower($offre->mineure) ?>"><?= $offre->mineure ?></h3>
                                    </div>
                                </div>
                                <div class="element-carte">
                                    <p class="element-carte-valeur"><?= $offre->remuneration ?> €/mois<br><?= $offre->places ?> places</p>
                                </div>
                            </div>

                            <div class="boutons-carte">
                                <!-- TODO: Action ajouter/supprimer de la wishlist -->
                                <?php if (estEtudiant()) { ?>
                                    <button class="bouton-carte">
                                        <i class="fa-solid fa-star"></i>
                                    </button>
                                    <span></span>
                                <?php } ?>

                                <button class="bouton-carte" onclick="location.href='<?= ADRESSE_SITE ?>/offre/lire/<?= $offre->id ?>'">
                                    <i class="fa-solid fa-eye"></i>
                                </button>

                                <?php if (estAdmin() || estPilote()) { ?>
                                    <span></span>
                                    <button class="bouton-carte" onclick="location.href='<?= ADRESSE_SITE ?>/offre/modifier/<?= $offre->id ?>'">
                                        <i class="fa-solid fa-pen"></i>
                                    </button>
                                    <span></span>
                                    <button class="bouton-carte" onclick="location.href='<?= ADRESSE_SITE ?>/offre/supprimer/<?= $offre->id ?>'">
                                        <i class="fa-solid fa-trash"></i>
                                    </button>
                                <?php } ?>
                            </div>
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
$titreOnglet = "Offres de stage StagEureka - Trouvez votre stage";
$metaDescription = "Page de liste des offres de stage du site StagEureka";
$navigationSelectionee = "offres";
$entetesSuplementaires = "<script src='" . ADRESSE_SITE . "/vue/js/image_offre_liste.js' defer></script>" .
    "<script src='" . ADRESSE_SITE . "/vue/js/filtre_wishlist.js'></script>";

// Inclut le template de mise en page
// (Affiche la page avec le contenu html généré précédemment et les variables déclarées ci-dessus)
include "vue/php/mise_en_page_vue.php";

?>