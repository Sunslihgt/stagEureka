<?php
require_once "outils.php";
require_once "modele/candidature_modele.php";

// On vérifie qu'il y a au moins un paramètre
if (count($params) < 1) {
    redirectionErreur(400);
    exit();
}

$action = $params[0];
switch ($action) {
    case "creer":
        // On vérifie que l'utilisateur est connecté et est un étudiant
        if (!estConnecte() || !estEtudiant() || !isset($_SESSION["id"])) {
            redirectionErreur(401, "Vous-devez-être-connecté-en-tant-qu'étudiant-pour-accéder-à-cette-page");
            exit();
        }
        $idEtudiant = $_SESSION["id"];

        // On vérifie qu'il y a un id d'offre
        if (count($params) != 2 || !is_numeric($params[1]) || $params[1] < 0) {
            redirectionErreur(400);
            exit();
        }
        $idOffre = intval($params[1]);

        afficherCreerCandidature($idEtudiant, $idOffre);
        break;
    case "lire":
            
        break;
    case "supprimer":
                
        break;
    default:
        redirectionErreur(400);
        exit();
}

function afficherCreerCandidature(int $idEtudiant, int $idOffre): void {
    if (isset($_POST)) {

    } else {
        $offre = getOffre($idOffre);

        if ($offre === null) {
            redirectionErreur(404);
            exit();
        }
        
        $etudiant = getEtudiant($idEtudiant);
        
        require_once "vue/creer_candidature_vue.php";
    }
}    