<?php
require_once "config.php";
require_once "modele/entreprise_modele.php";
require_once "modele/adresse_modele.php";

// var_dump($params);

// Si pas de paramètre, on redirige vers la liste des entreprises
if (count($params) == 0 || $params[0] == "") {
    header("Location: " . ADRESSE_SITE . "/entreprise/liste");
    exit();
}

$action = $params[0];
switch ($action) {
    case "liste":
        afficherListeEntreprises($params);
        break;
    case "lire":
        // var_dump(getAdresses());
        // var_dump(getAdresse(1));
        // var_dump(getAdressesEntreprise(1));
        # code...
        break;
    case "creer":
        # code...
        break;
    case "modifier":
        # code...
        break;
    case "supprimer":
        # code...
        break;
    default:
        # code...
        break;
}

function afficherListeEntreprises($params): void {
    if (count($params) > 1) {
        header("Location: " . ADRESSE_SITE . "/entreprise/liste");
    }

    if (isset($_POST)) {  // Filtres de recherche trouvés
        $nomEntrepriseFiltre = isset($_POST["nom-entreprise-filtre"]) ? $_POST["nom-entreprise-filtre"] : "";
        $localisationFiltre = isset($_POST["localisation-filtre"]) ? $_POST["localisation-filtre"] : "";
        $notePiloteFiltre = isset($_POST["note-pilote-filtre"]) && is_numeric($_POST["note-pilote-filtre"]) ? intval($_POST["note-pilote-filtre"]) : -1;
        $noteEtudiantFiltre = isset($_POST["note-etudiant-filtre"]) && is_numeric($_POST["note-etudiant-filtre"]) ? intval($_POST["note-etudiant-filtre"]) : -1;
        
        // On récupère les entreprises filtrées
        $entreprises = getEntreprisesFiltre($nomEntrepriseFiltre, $localisationFiltre, $notePiloteFiltre, $noteEtudiantFiltre);

        require_once "vue/php/entreprise/liste_entreprises.php";
    } else {  // Pas de filtres
        $entreprises = getEntreprises(true);

        require_once "vue/php/entreprise/liste_entreprises.php";
    }
}

function modifierEntreprise($params): void {
    // TODO: Modifier une entreprise
}

function supprimerEntreprise($params): void {
    // TODO: Supprimer une entreprise
}
