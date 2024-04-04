<?php

require_once "outils.php";
require_once "modele/candidature_modele.php";
require_once "modele/etudiant_modele.php";

// On vérifie qu'il y a au moins un paramètre
if (count($params) < 1) {
    redirectionErreur(400);
    exit();
}

$action = $params[0];
switch ($action) {
    case "candidature":
        afficherFichierCandidature($params);
        break;
    default:
        redirectionErreur(400);
        break;
}

function afficherFichierCandidature(array $params): void {
    if (count($params) != 2 || !is_numeric($params[1]) || $params[1] < 0) {
        redirectionErreur(400);
        exit();
    }

    $idCandidature = intval($params[1]);
    $candidature = getCandidature($idCandidature);
    if ($candidature === null) {
        redirectionErreur(404);
        exit();
    }

    $etudiant = getEtudiant($candidature->idEtudiant);

    if (estConnecte() && (estAdmin() || estPilote() || (estEtudiant() && $candidature->idEtudiant == $_SESSION["id"]))) {
        // Entête HTTP pour indiquer que le fichier est un pdf
        header('Content-Type: application/pdf');
        header('Content-Disposition: attachment; filename="CV-' . $etudiant->nom . "-" . $etudiant->prenom . '.pdf"');
        echo $candidature->cvFichier;  // Affiche le fichier pdf
        exit();
    } else {
        redirectionErreur(401, "Vous-n'avez-pas-l'autorisation-d'accéder-à-cette-ressource");
        exit();
    }
}
