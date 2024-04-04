<?php
require_once "outils.php";
require_once "modele/candidature_modele.php";
require_once "modele/etudiant_modele.php";
require_once "modele/offre_modele.php";

// On vérifie qu'il y a au moins un paramètre
if (count($params) < 1) {
    redirectionErreur(400);
    exit();
}

$action = $params[0];
switch ($action) {
    case "liste":
        afficherListeCandidatures($params);
        break;
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
        // On vérifie qu'il y a un id d'offre
        if (count($params) != 2 || !is_numeric($params[1]) || $params[1] < 0) {
            redirectionErreur(400);
            exit();
        }
        $idCandidature = intval($params[1]);

        afficherLireCandidature($idCandidature);
        break;
    case "supprimer":
        // On vérifie qu'il y a un id d'offre
        if (count($params) != 2 || !is_numeric($params[1]) || $params[1] < 0) {
            redirectionErreur(400);
            exit();
        }
        $idCandidature = intval($params[1]);

        afficherSupprimerCandidature($idCandidature);

        break;
    default:
        redirectionErreur(400);
        exit();
}

function afficherLireCandidature(int $idCandidature): void {
    $candidature = getCandidature($idCandidature);
    if ($candidature === null) {
        redirectionErreur(404);
        exit();
    }

    // if (DEBUG) var_dump($_SESSION["id"], $candidature->idEtudiant, $_SESSION["id"] === $candidature->idEtudiant);
    
    if (estConnecte() && (estAdmin() || estPilote() || (estEtudiant() && $candidature->idEtudiant == $_SESSION["id"]))) {
        $etudiant = getEtudiant($candidature->idEtudiant);
        $offre = getOffre($candidature->idOffre);
        require_once "vue/php/candidature/lire_candidature_vue.php";
    } else {
        redirectionErreur(401, "Vous-ne-pouvez-pas-accéder-à-cette-candidature-(elle-ne-vous-appartient-pas)");
        exit();
    }
}

function afficherListeCandidatures(array $params): void {
    if (count($params) != 1) {
        redirectionErreur(400);
        exit();
    }

    $nomEtudiant = isset($_POST["nom"]) ? $_POST["nom"] : "";
    $prenomEtudiant = isset($_POST["prenom"]) ? $_POST["prenom"] : "";
    $nomOffre = isset($_POST["nomOffre"]) ? $_POST["nomOffre"] : "";
    
    $idEtudiant = -1;
    if (estEtudiant()) {
        $idEtudiant = $_SESSION["id"];
    }

    // if (DEBUG) var_dump($nomEtudiant, $prenomEtudiant, $nomOffre, $idEtudiant);

    $candidatures = getCandidaturesFiltre($nomEtudiant, $prenomEtudiant, $nomOffre, $idEtudiant);

    // if (DEBUG) var_dump($candidatures);
    require_once "vue/php/candidature/liste_candidatures_vue.php";
}

function afficherCreerCandidature(int $idEtudiant, int $idOffre): void {
    // if (DEBUG) var_dump($_POST);
    // if (DEBUG) echo "<br>";
    // if (DEBUG) var_dump($_FILES["cv"]);
    // if (DEBUG) echo "<br>";

    if (isset($_POST) && isset($_POST["motivation"]) && isset($_FILES) && isset($_FILES["cv"]) && $_FILES["cv"]["error"] == 0 && $_FILES["cv"]["type"] == "application/pdf") {
        $motivation = $_POST["motivation"];
        // $cv = $_FILES["cv"];
        $cvFichier = file_get_contents($_FILES['cv']['tmp_name']);
        // if (DEBUG) var_dump($cvFichier);

        $candidatureExistante = getCandidaturesFiltre("", "", "", $idEtudiant);
        if (count($candidatureExistante) > 0) {
            redirectionErreur(400, "Vous-avez-déjà-postulé-à-cette-offre");
            exit();
        }

        $candidatureCree = creerCandidature($idEtudiant, $idOffre, $motivation, $cvFichier);

        if (DEBUG) var_dump("Candidature créée: ", $candidatureCree);

        if ($candidatureCree) {
            redirectionInterne("offre/liste");
            exit();
        } else {
            redirectionErreur(500, "Erreur-lors-de-la-création-de-la-candidature-(la-candidature-existe-peut-être-déjà)");
            exit();
        }
    } else {
        $offre = getOffre($idOffre);
        if ($offre === null) {
            redirectionErreur(404);
            exit();
        }

        $etudiant = getEtudiant($idEtudiant);
        // if (DEBUG) var_dump($etudiant, $offre);

        require_once "vue/php/candidature/creer_candidature_vue.php";
    }
}

function afficherSupprimerCandidature(int $idCandidature): void {
    $candidature = getCandidature($idCandidature);
    if ($candidature === null) {
        redirectionErreur(404);
        exit();
    }

    // if (DEBUG) var_dump($_SESSION["id"], $candidature->idEtudiant, $_SESSION["id"] === $candidature->idEtudiant);

    if (estConnecte() && (estAdmin() || estPilote() || (estEtudiant() && $candidature->idEtudiant == $_SESSION["id"]))) {
        $etudiant = getEtudiant($candidature->idEtudiant);
        $offre = getOffre($candidature->idOffre);

        if (isset($_POST) && isset($_POST["confirmation"]) && $_POST["confirmation"] === "oui") {
            $candidatureSupprimee = supprimerCandidature($idCandidature);

            if (DEBUG) var_dump("Candidature supprimée: ", $candidatureSupprimee);

            if ($candidatureSupprimee) {
                redirectionInterne("candidature/liste");
                exit();
            } else {
                redirectionErreur(500, "Erreur-lors-de-la-suppression-de-la-candidature");
                exit();
            }
        } else {
            require_once "vue/php/candidature/supprimer_candidature_vue.php";
        }
    } else {
        redirectionErreur(401, "Vous-ne-pouvez-pas-accéder-à-cette-candidature-(elle-ne-vous-appartient-pas)");
        exit();
    }
}
