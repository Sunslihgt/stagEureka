<?php
// Routeur du site web
// (Point d'entrée du site web)

// Inclusion des fichiers de configuration
require_once "outils.php";

// if (DEBUG) echo "Passage par le routeur!<br>";
// if (DEBUG) var_dump($_GET);

// if (DEBUG) echo "<br>ADRESSE_SITE: " . ADRESSE_SITE . "<br>";

// Démarrage de la session si nécessaire
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
// if (DEBUG) var_dump($_SESSION);
// if (DEBUG) echo "<br>";

// if (DEBUG) echo password_hash("test", PASSWORD_DEFAULT);

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
                if (estConnecte()) {
                    include_once "controleur/offre.php";
                } else {
                    redirectionErreur(401, "Vous-devez-être-connecté-pour-accéder-à-cette-page");  // Erreur 401: Non autorisé
                }
                break;
            case "entreprise":
                if (estConnecte()) {
                    include_once "controleur/entreprise.php";
                } else {
                    redirectionErreur(401, "Vous-devez-être-connecté-pour-accéder-à-cette-page");  // Erreur 401: Non autorisé
                }
                break;
            case "pilote":
                if (estConnecte()) {
                    if (estAdmin()) {
                        include_once "controleur/pilote.php";
                    } else {
                        redirectionErreur(401, "Vous-devez-être-un-administrateur-pour-accéder-à-cette-page");  // Erreur 401: Non autorisé
                    }
                } else {
                    redirectionErreur(401, "Vous-devez-être-connecté-pour-accéder-à-cette-page");  // Erreur 401: Non autorisé
                }
                break;
            case "etudiant":
                if (estConnecte()) {
                    if (!estEtudiant()) {
                        include_once "controleur/etudiant.php";
                    } else {
                        redirectionErreur(401, "Vous-devez-être-un-pilote-ou-un-administrateur-pour-accéder-à-cette-page");  // Erreur 401: Non autorisé
                    }
                } else {
                    redirectionErreur(401, "Vous-devez-être-connecté-pour-accéder-à-cette-page");  // Erreur 401: Non autorisé
                }
                break;
            case "connexion":
                if (!estConnecte()) {
                    include_once "controleur/connexion.php";
                } else {
                    redirectionErreur(401, "Vous-devez-être-déconnecté-pour-accéder-à-cette-page");  // Erreur 401: Non autorisé
                }
                break;
            case "deconnexion":
                if (estConnecte()) {
                    include_once "controleur/deconnexion.php";
                } else {
                    redirectionErreur(401, "Vous-devez-être-connecté-pour-accéder-à-cette-page");  // Erreur 401: Non autorisé
                }
                break;
            case "erreur":  // Contrôleur d'erreur
                $erreurAffichee = include_once "controleur/erreur.php";
                if (!$erreurAffichee) {  // Contrôleur d'erreur non trouvé
                    redirectionErreur(400);  // Erreur 400: Mauvaise requête
                }
                break;
            default:  // Contrôleur inconnu ou contrôleur d'erreur
                redirectionErreur(404);  // Erreur 404: Non trouvé
                break;
        }
    } else {
        // Redirige vers la page d'accueil par défaut
        redirectionAccueil();
    }
}


