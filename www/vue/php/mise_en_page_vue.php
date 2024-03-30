<?php
// Page de mise en page utilisée pour toutes les pages du site

/**
 * Utilise les variables suivantes:
 * - $titreOnglet: Titre de la page affiché dans l'onglet du navigateur
 * - $metaDescription: Description de la page pour les moteurs de recherche
 * - $entetesSuplementaires: Code HTML à ajouter dans la balise <head> de la page (scripts, styles, etc.)
 * - $navigationSelectionee: Nom de la page de navigation à mettre en surbrillance (par défaut aucune)
 * - $contenu: Contenu de la page à afficher après la barre de navigation
 */

// Tableau associatif des objets de navigation et de leur identifiant html
// Les clés sont les noms des pages de navigation et les valeurs sont les identifiants html des objets de navigation
const OBJETS_NAVIGATION = [
    "accueil" => "nav-accueil",
    "offres" => "nav-offres",
    "entreprises" => "nav-entreprises",
    "etudiants" => "nav-etudiants",
    "pilotes" => "nav-pilotes",
];

?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="<?= $metaDescription ?? "Page du site StagEureka" ?> ">
    <!-- Affiche le titre de la page ou le nom du site -->
    <title><?= $titreOnglet ?? "StagEureka" ?></title>
    <link rel="stylesheet" href="<?= ADRESSE_SITE ?>/vue/css/style.css">
    <link rel="icon" type="image/jpeg" href="<?= ADRESSE_SITE ?>/vue/ressources/images/StagEureka-logo_200x200.jpg">
    <script src="https://kit.fontawesome.com/abdb6c54cc.js" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <script src="<?= ADRESSE_SITE ?>/vue/js/theme.js"></script>
    <?= $entetesSuplementaires ?? "" ?>
</head>

<body>
    <!-- Barre de navigation -->
    <header>
        <div id="header-div">
            <div id="header-logo-div">
                <a href="<?= ADRESSE_SITE ?>/accueil">
                    <img src="<?= ADRESSE_SITE ?>/vue/ressources/images/logo_complet_clair_compresse.jpg" alt="Logo StagEureka" class="logo" id="logo-light" hidden>
                    <img src="<?= ADRESSE_SITE ?>/vue/ressources/images/logo_complet_sombre_compresse.jpg" alt="Logo StagEureka" class="logo" id="logo-dark" hidden>
                </a>
            </div>

            <div id="header-button-div">
                <?php if (isset($_SESSION["prenom"])) { ?>
                    <a class="header-button" href="<?= ADRESSE_SITE ?>/deconnexion" title="Déconnexion">
                        <?= $_SESSION["prenom"] ?>
                        <i class="fa-solid fa-arrow-right-from-bracket"></i>
                    </a>
                <?php } else { ?>
                    <a class="header-button" href="<?= ADRESSE_SITE ?>/connexion" title="Connexion">Connexion</a>
                <?php } ?>

                <span></span>

                <div id="div-switch">
                    <div class="switch">
                        <input type="checkbox" id="checkbox-theme">
                        <label class="slider" for="checkbox-theme"></label>
                        <div class="slider-carte">
                            <div class="slider-carte-face slider-carte-gauche"></div>
                            <div class="slider-carte-face slider-carte-droite"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div>
            <nav>
                <ul>
                    <li id="nav-accueil"><a href="<?= ADRESSE_SITE ?>/accueil">Accueil</a></li>
                    <li id="nav-offres"><a href="<?= ADRESSE_SITE ?>/offre">Offres</a></li>
                    <li id="nav-entreprises"><a href="<?= ADRESSE_SITE ?>/entreprise">Entreprises</a></li>
                    <li id="nav-etudiants"><a href="<?= ADRESSE_SITE ?>/etudiant">Étudiants</a></li>
                    <li id="nav-pilotes"><a href="<?= ADRESSE_SITE ?>/pilote">Pilotes</a></li>
                </ul>
            </nav>
        </div>
        <!-- Surbrillance d'un des boutons de navigation en fonction de la page actuelle -->
        <script>
            <?php if (isset($navigationSelectionee) && isset(OBJETS_NAVIGATION[$navigationSelectionee])) { ?>
                document.getElementById("<?= OBJETS_NAVIGATION[$navigationSelectionee] ?>").classList.add("nav-selected");
            <?php } ?>
        </script>
    </header>

    <!-- Contenu principal du site -->
    <?= $contenu ?>

    <footer>
        <a href="<?= ADRESSE_SITE ?>/legale">Informations légales</a>
    </footer>
</body>

</html>