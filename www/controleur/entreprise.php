<?php
require_once "outils.php";
require_once "modele/entreprise_modele.php";
require_once "modele/adresse_modele.php";

// if (DEBUG) var_dump($params);

// Si pas de paramètre, on redirige vers la liste des entreprises
if (count($params) == 0 || $params[0] == "") {
    redirectionInterne("entreprise/liste");
    exit();
}

$action = $params[0];
switch ($action) {
    case "liste":
        afficherListeEntreprises($params);
        break;
    case "lire":
        afficherLectureEntreprise($params);
        break;
    case "creer":
        // On vérifie que l'utilisateur est connecté et n'est pas un étudiant
        if (estAdmin() || estPilote()) {
            afficherCreerEntreprise($params);
        } else {
            redirectionErreur(401);  // Erreur 401 (Non autorisé)
        }
        break;
    case "modifier":
        // On vérifie que l'utilisateur est connecté et n'est pas un étudiant
        if (estAdmin() || estPilote()) {
            afficherModifierEntreprise($params);
        } else {
            redirectionErreur(401);  // Erreur 401 (Non autorisé)
        }
        break;
    case "supprimer":
        // On vérifie que l'utilisateur est connecté et n'est pas un étudiant
        if (estAdmin() || estPilote()) {
            afficherSupprimerEntreprise($params);
        } else {
            redirectionErreur(401);  // Erreur 401 (Non autorisé)
        }
        break;
    default:  // Mot clé non reconnu
        redirectionInterne("entreprise/liste");
        break;
}

function afficherListeEntreprises(array $params): void {
    if (count($params) > 1) {
        redirectionInterne("entreprise/liste");
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

function afficherLectureEntreprise(array $params): void {
    if (count($params) != 2 || !is_numeric($params[1]) || $params[1] < 0) {
        redirectionInterne("entreprise/liste");
    }

    $idEntreprise = $params[1];
    $entreprise = getEntreprise($idEntreprise, true);

    if (is_null($entreprise)) {
        redirectionErreur(404);  // Erreur 404 (Non trouvé)
    }
    require_once "vue/php/entreprise/lire_entreprise_vue.php";
}

function afficherCreerEntreprise(array $params): void {
    if (count($params) > 1) {
        redirectionInterne("entreprise/creer");
    }

    // if (DEBUG) var_dump($_POST);
    if (isset($_POST) && isset($_POST["entreprise"]) && isset($_POST["numeroRue"]) && isset($_POST["rue"]) && isset($_POST["ville"]) && isset($_POST["codePostal"]) && isset($_POST["domaine"])) {
        $nomEntreprise = $_POST["entreprise"];
        $numeroRue = $_POST["numeroRue"];
        $rue = $_POST["rue"];
        $ville = $_POST["ville"];
        $codePostal = $_POST["codePostal"];
        $domaine = $_POST["domaine"];
        $visible = isset($_POST["visible"]) ? true : false;

        $idEntreprise = creerEntreprise($nomEntreprise, $numeroRue, $rue, $ville, $codePostal, $domaine, $visible);

        if (!is_null($idEntreprise)) {  // Entreprise créée
            redirectionInterne("entreprise/liste");  // Redirection vers la liste des entreprises
        } else {  // Erreur lors de la création de l'entreprise
            redirectionInterne("entreprise/creer");  // Redirection vers la page de création d'entreprise
        }
    } else {
        require_once "vue/php/entreprise/creer_entreprise_vue.php";
    }
}

function afficherModifierEntreprise(array $params): void {
    if (count($params) != 2 || !is_numeric($params[1]) || $params[1] < 0) {
        redirectionInterne("entreprise/liste");
    }

    $idEntreprise = $params[1];
    // $idEntreprise = intval($params[1]);
    // if (DEBUG) echo var_dump($idEntreprise) . "<br>";

    // if (DEBUG) echo var_dump($_POST) . "<br>";
    // if (isset($_POST) && isset($_POST["entreprise"]) && isset($_POST["numeroRue"]) && isset($_POST["rue"]) && isset($_POST["ville"]) && isset($_POST["codePostal"]) && isset($_POST["domaine"])) {
    if (isset($_POST) && isset($_POST["entreprise"]) && isset($_POST["domaine"])) {
        $nomEntreprise = $_POST["entreprise"];
        // $numeroRue = $_POST["numeroRue"];
        // $rue = $_POST["rue"];
        // $ville = $_POST["ville"];
        // $codePostal = $_POST["codePostal"];
        $domaine = $_POST["domaine"];
        $visible = isset($_POST["visible"]) ? true : false;

        // $entrepriseModifiee = modifierEntreprise($idEntreprise, $nomEntreprise, $numeroRue, $rue, $ville, $codePostal, $domaine, $visible);
        $entrepriseModifiee = modifierEntreprise($idEntreprise, $nomEntreprise, $domaine, $visible);
        // if (DEBUG) echo "Entreprise modifiée: " . var_dump($entrepriseModifiee) . "<br>";

        if ($entrepriseModifiee) {  // Entreprise modifiée
            redirectionInterne("entreprise/liste");  // Redirection vers la liste des entreprises
        } else {  // Erreur lors de la modification de l'entreprise
            redirectionInterne("entreprise/modifier");  // Redirection vers la page de modification d'entreprise
        }
    } else {
        $entreprise = getEntreprise($idEntreprise, false);

        if (is_null($entreprise)) {
            redirectionErreur(404);  // Erreur 404 (Non trouvé)
        }
        require_once "vue/php/entreprise/modifier_entreprise_vue.php";
    }
}

function afficherSupprimerEntreprise(array $params): void {
    if (count($params) != 2 || !is_numeric($params[1]) || $params[1] < 0) {
        redirectionInterne("entreprise/liste");
    }

    $idEntreprise = $params[1];

    if (isset($_POST) && isset($_POST["confirmation"]) && $_POST["confirmation"] == "oui") {  // Suppression confirmée
        $entrepriseSupprimee = supprimerEntreprise($idEntreprise);
        if ($entrepriseSupprimee) {
            redirectionInterne("entreprise/liste");
        } else {  // Erreur lors de la suppression de l'entreprise
            // La suppression échouera si l'entreprise est liée à des offres, des notes...
            redirectionErreur(409, "Impossible-de-supprimer-l'entreprise-(essayez-de-la-cacher)");  // Erreur 409 (Conflit)
        }
    } else {  // Demande de confirmation de suppression
        $entreprise = getEntreprise($idEntreprise, false);

        if (is_null($entreprise)) {
            redirectionErreur(404);  // Erreur 404 (Non trouvé)
        }
        require_once "vue/php/entreprise/supprimer_entreprise_vue.php";
    }
}
