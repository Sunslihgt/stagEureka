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
    // case "lire":
    //     // var_dump(getAdresses());
    //     // var_dump(getAdresse(1));
    //     // var_dump(getAdressesEntreprise(1));
    //     # code...
    //     break;
    case "creer":
        affcherCreerEntreprise($params);
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

        require_once "vue/php/entreprise/liste_entreprises_vue.php";
    } else {  // Pas de filtres
        $entreprises = getEntreprises(true);

        require_once "vue/php/entreprise/liste_entreprises_vue.php";
    }
}

function affcherCreerEntreprise(array $params): void {
    if (count($params) > 1) {
        header("Location: " . ADRESSE_SITE . "/entreprise/liste");
    }

    var_dump($_POST);
    if (isset($_POST) && isset($_POST["entreprise"]) && isset($_POST["numeroRue"]) && isset($_POST["rue"]) && isset($_POST["ville"]) && isset($_POST["codePostal"]) && isset($_POST["domaine"])) {
        $nomEntreprise = $_POST["entreprise"];
        $numeroRue = $_POST["numeroRue"];
        $rue = $_POST["rue"];
        $ville = $_POST["ville"];
        $codePostal = $_POST["codePostal"];
        $domaine = $_POST["domaine"];
        $visible = isset($_POST["visible"]) ? true : false;

        $idEntreprise = creerEntreprise($nomEntreprise, $numeroRue, $rue, $ville, $codePostal, $domaine, $visible);
        echo "<br>idEntreprise: " . $idEntreprise . "<br>";

        if (!is_null($idEntreprise)) {  // Entreprise créée
            header("Location: " . ADRESSE_SITE . "/entreprise/liste");  // Redirection vers la liste des entreprises
        } else {  // Erreur lors de la création de l'entreprise
            header("Location: " . ADRESSE_SITE . "/entreprise/creer");  // Redirection vers la page de création d'entreprise
        }
    } else {
        require_once "vue/php/entreprise/creer_entreprise_vue.php";
    }
}

function afficherModifierEntreprise(array $params): void {
    // TODO: Modifier une entreprise
}

function afficherSupprimerEntreprise(array $params): void {
    // TODO: Supprimer une entreprise
}
