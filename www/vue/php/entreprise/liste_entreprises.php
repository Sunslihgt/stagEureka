<?php
include_once "config.php";

// Démarre la temporisation de sortie
// (Permet de stocker le contenu html suivant dans une variable php)
ob_start();
?>

<main class="main-affichage" id="main-liste-entreprises">
    <form action="wip_liste_entreprise_filtre.php" method="post">
        <div class="block-recherche" id="block-recherche-entreprises">
            <div id="champs-filtre">
                <div class="barres-recherche">
                    <div class="element-recherche" id="entreprise-recherche">
                        <label for="nom-entreprise-filtre">Nom</label>
                        <input type="text" placeholder="Recherche via l'entreprise" class="case-recherche" id="nom-entreprise-filtre">
                    </div>
                    <span></span>
                    <div class="element-recherche" id="localisation-recherche">
                        <label for="nom-localisation-filtre">Localisation</label>
                        <input type="text" placeholder="Recherche via localisation" class="case-recherche" id="nom-localisation-filtre">
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
                        <input type="hidden" name="note-pilote" id="note-pilote" value="1">
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
                        <input type="hidden" name="note-etudiant" id="note-etudiant" value="1">
                    </div>
                </div>
            </div>
            <button type="submit" class="bouton-filtrage">Filtrer</button>
        </div>
    </form>

    <div class="affichage-cartes">
        <div class="haut-page-liste-resultats">
            <h1 id="haut-h1">Liste des Entreprises</h1>
            <button id="haut-bouton">Ajouter une Entreprise</button>
        </div>

        <div id="selection-entreprise">
            <?php foreach ($entreprises as $entreprise) { ?>
                <div class="carte carte-entreprise" id="carte-entreprise-<?= $entreprise->id ?>">
                    <div class="info-carte">
                        <div class="element-carte">
                            <p class="element-carte-titre">Nom</p>
                            <p class="element-carte-valeur"><?= $entreprise->nom ?></p>
                        </div>
                        <div class="element-carte">
                            <p class="element-carte-titre">Localisation</p>
                            <p class="element-carte-valeur">St Nazaire</p>
                        </div>
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
                                <i class="fa-solid fa-star"></i>
                                <i class="fa-solid fa-star"></i>
                                <i class="fa-regular fa-star"></i>
                                <i class="fa-regular fa-star"></i>
                                <i class="fa-regular fa-star"></i>
                            </p>
                        </div>
                        <div class="element-carte div-carte-note-etudiant">
                            <p class="element-carte-titre">Etudiants</p>
                            <p class="etoiles-bleues">
                                <i class="fa-solid fa-star"></i>
                                <i class="fa-regular fa-star"></i>
                                <i class="fa-regular fa-star"></i>
                                <i class="fa-regular fa-star"></i>
                                <i class="fa-regular fa-star"></i>
                            </p>
                        </div>
                        <div class="boutons-carte">
                            <button class="bouton-carte bouton-modification"><i class="fa-solid fa-pen"></i></button>
                            <span></span>
                            <button class="bouton-carte bouton-suppression"><i class="fa-solid fa-trash"></i></button>
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
$titreOnglet = "Entreprises StagEureka - Trouvez votre stage";
$metaDescription = "Page de liste des entreprises du site StagEureka";
$navigationSelectionee = "entreprise";
$entetesSuplementaires = "<script src='" . ADRESSE_SITE . "/vue/js/filtre_etoile.js'></script>";

// Inclut le template de mise en page
// (Affiche la page avec le contenu html généré précédemment et les variables déclarées ci-dessus)
include "vue/php/mise_en_page.php";

?>