<?php
include_once "outils.php";

// Démarre la temporisation de sortie
// (Permet de stocker le contenu html suivant dans une variable php)
ob_start();
?>

<main class="main-affichage" id="main-liste-etudiants">
        <form action="<?= ADRESSE_SITE ?>/etudiant/liste" method="post">
            <div class="block-recherche" id="block-recherche-etudiants">
                <div class="barres-recherche">
                    <div class="element-recherche">
                        <label for="nom-etudiant-filtre">Nom de l'étudiant</label>
                        <input type="text" placeholder="Recherche via le nom" class="case-recherche" id="nom-etudiant-filtre">
                    </div>
                    <div class="element-recherche">
                        <label for="prenom-etudiant-filtre">Prénom de l'étudiant</label>
                        <input type="text" placeholder="Recherche via le prénom" class="case-recherche"  id="prenom-etudiant-filtre">
                    </div>
                    <div class="element-recherche">
                        <label for="campus-etudiant-filtre">Campus de l'étudiant</label>
                        <input type="text" placeholder="Recherche via le campus" class="case-recherche" id="campus-etudiant-filtre">
                    </div>
                    <div class="element-recherche">
                        <label for="classe-etudiant-filtre">Classe de l'étudiant</label>
                        <input type="text" placeholder="Recherche via la classe" class="case-recherche" id="classe-etudiant-filtre">
                    </div>
                </div>

                <button type="submit" class="bouton-filtrage">Filtrer</button>
            </div>
        </form>

        <div class="affichage-cartes">
            <div class="haut-page-liste-resultats">
                <h1 id="haut-h1">Liste des Etudiants</h1>
                <button id="haut-bouton" onclick="location.href='<?= ADRESSE_SITE ?>/etudiant/creer'">Ajouter un Etudiant</button>
            </div>

            <div id="selection-etudiant">
                <?php foreach ($etudiants as $etudiant) { ?>
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
                            <!-- <div class="element-carte div-carte-campus">
                                <p class="element-carte-titre">Campus</p>
                                <p class="element-carte-valeur">NOM DU CAMPUS</p>
                            </div> -->
                            <!-- <div class="element-carte">
                                <p class="element-carte-titre">Classe</p>
                                <p class="element-carte-valeur">CLASSE DE L'ELEVE</p>
                            </div> -->

                            <div class="boutons-carte">
                                <button class="bouton-carte bouton-lecture" onclick="location.href='<?= ADRESSE_SITE ?>/etudiant/lire/<?= $etudiant->id ?>'"><i class="fa-solid fa-eye"></i></button>
                                <span></span>
                                <button class="bouton-carte bouton-modification" onclick="location.href='<?= ADRESSE_SITE ?>/etudiant/modifier/<?= $etudiant->id ?>'"><i class="fa-solid fa-pen"></i></button>
                                <span></span>
                                <button class="bouton-carte bouton-suppression" onclick="location.href='<?= ADRESSE_SITE ?>/etudiant/supprimer/<?= $etudiant->id ?>'"><i class="fa-solid fa-trash"></i></button>
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
$titreOnglet = "Etudiants StagEureka - Trouvez votre stage";
$metaDescription = "Page de liste des étudiants du site StagEureka";
$navigationSelectionee = "etudiants";
// $entetesSuplementaires = "<script src='" . ADRESSE_SITE . "/vue/js/champ_mdp.js'></script>";

// Inclut le template de mise en page
// (Affiche la page avec le contenu html généré précédemment et les variables déclarées ci-dessus)
include "vue/php/mise_en_page_vue.php";

?>