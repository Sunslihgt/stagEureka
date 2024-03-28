<?php
// Routeur du site web
// (Point d'entrée du site web)

// Inclusion des fichiers de configuration
require_once "config.php";

// echo "Passage par le routeur!<br>";
// var_dump($_GET);

// echo "ADRESSE_SITE: " . ADRESSE_SITE . "<br>";
routageGlobal();


function routageGlobal(): void {
    if (isset($_GET) && isset($_GET["url"])) {
        $url = $_GET['url'];
        $urlParts = explode('/', $url);
        if (empty($urlParts) || $urlParts[0] == "") {  // Pas d'adresse donnée
            redirectionAccueil();
            exit();
        }

        // Récupère le nom du contrôleur demandé
        $controleur = $urlParts[0];
        $params = array_slice($urlParts, 1);
        switch ($controleur) {
            case "accueil":
                include_once "controleur/accueil.php";
                break;
            case "legal":
                include_once "controleur/legal.php";
                break;
            case "offre":
                include_once "controleur/offre.php";
                break;
            case "entreprise":
                include_once "controleur/entreprise.php";
                break;
            case "pilote":
                include_once "controleur/pilote.php";
                break;
            case "etudiant":
                include_once "controleur/etudiant.php";
                break;
            case "connexion":
                include_once "controleur/connexion.php";
                break;
            case "erreur":  // Contrôleur d'erreur
                $erreurAffichee = include_once "controleur/erreur.php";
                if (!$erreurAffichee) {  // Contrôleur d'erreur non trouvé
                    redirectionErreur(400);
                }
                break;
            default:  // Contrôleur inconnu ou contrôleur d'erreur
                redirectionErreur();
                break;
        }
    } else {
        // Redirige vers la page d'accueil par défaut
        header("Location: html_temp/accueil.html");
    }
}

/**
 * Redirige vers la page d'accueil
 */
function redirectionAccueil(): void {
    header("Location: " . ADRESSE_SITE . "/accueil");
}

/**
 * Redirige vers la page d'erreur
 * @param int $codeErreur Code d'erreur HTTP
 */
function redirectionErreur(int $codeErreur = 404): void {
    header("Location: " . ADRESSE_SITE . "/erreur/$codeErreur");
}
