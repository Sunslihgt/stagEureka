<?php
require_once "outils.php";
require_once "modele/offre_modele.php";
require_once "modele/adresse_modele.php";

// if (DEBUG) echo var_dump($offres) . "<br>";

// Si pas de paramètre, on redirige vers la liste des offres
if (count($params) == 0 || $params[0] == "") {
    redirectionInterne("offre/liste");
    exit();
}

$action = $params[0];
switch ($action) {
    case "liste":
        afficherListeOffres($params);
        break;
    case "lire":
        afficherLectureOffre($params);
        break;
    case "creer":
        // On vérifie que l'utilisateur est connecté et n'est pas un étudiant
        if (estAdmin() || estPilote()) {
            afficherCreerOffre($params);
        } else {  // Si l'utilisateur n'est pas autorisé
            redirectionErreur(401, "/erreur/401/Seuls-les-administrateurs-et-les-pilotes-peuvent-cr%C3%A9er-des-offres-de-stage");  // Erreur 401 (Non autorisé)
        }
        break;
    case "modifier":
        // On vérifie que l'utilisateur est connecté et n'est pas un étudiant
        if (estAdmin() || estPilote()) {
            afficherModifierOffre($params);
        } else {  // Si l'utilisateur n'est pas autorisé
            redirectionErreur(401, "/erreur/401/Seuls-les-administrateurs-et-les-pilotes-peuvent-modifier-des-offres-de-stage");  // Erreur 401 (Non autorisé)
        }
        break;
    case "supprimer":
        // On vérifie que l'utilisateur est connecté et n'est pas un étudiant
        if (estAdmin() || estPilote()) {
            afficherSupprimerOffre($params);
        } else {  // Si l'utilisateur n'est pas autorisé
            redirectionErreur(401, "/erreur/401/Seuls-les-administrateurs-et-les-pilotes-peuvent-supprimer-des-offres-de-stage");  // Erreur 401 (Non autorisé)
        }
        break;
    default:  // Mot clé non reconnu
        redirectionInterne("offre/liste");
        break;
}

function afficherLectureOffre(array $params) {
    if (count($params) != 2 || !is_numeric($params[1]) || intval($params[1]) < 0) {
        redirectionInterne("offre/liste");
    }

    $idOffre = intval($params[1]);
    $offre = getOffre($idOffre);

    if (is_null($offre)) {
        redirectionErreur(404);  // Erreur 404 (Non trouvé)
    }

    require_once "vue/php/offre/lire_offre_vue.php";
}

function afficherListeOffres(array $params): void {
    if (count($params) > 1) {
        redirectionInterne("offre/liste");
    }

    if (isset($_POST)) {  // Filtres de recherche trouvés
        // On récupère les offres filtrées
        // $offres = getOffresFiltre($nomEntrepriseFiltre, $localisationFiltre, $notePiloteFiltre, $noteEtudiantFiltre);
        $offres = getOffres();

        require_once "vue/php/offre/liste_offres_vue.php";
    } else {  // Pas de filtres
        $offres = getOffres();

        require_once "vue/php/offre/liste_offres_vue.php";
    }
}

function afficherCreerOffre(array $params) {
    if (count($params) > 1) {
        redirectionInterne("offre/liste");
    }

    // if (DEBUG) var_dump($_POST);
    // Filtre massif pour s'assurer que toutes les données sont présentes et valides
    if (
        isset($_POST) && isset($_POST["titre"]) && isset($_POST["numeroRue"]) &&
        isset($_POST["ville"]) && isset($_POST["mineure"]) && isset($_POST["URL"]) &&
        isset($_POST["competences"]) && isset($_POST["description"]) &&
        isset($_POST["codePostal"]) && preg_match('/^\d{5}$/', strval($_POST["codePostal"])) &&  // Vérifie que le code postal est valide (5 chiffres)
        isset($_POST["rue"]) && is_numeric($_POST["numeroRue"]) && intval($_POST["numeroRue"]) > 0 &&  // Vérifie que le numéro de rue est valide (entier positif)
        isset($_POST["remuneration"]) && is_numeric($_POST["remuneration"]) && intval($_POST["remuneration"]) >= 0 &&  // Vérifie que la rémunération est valide (entier positif ou nul)
        isset($_POST["place"]) && is_numeric($_POST["place"]) && intval($_POST["place"]) > 0 &&  // Vérifie que le nombre de places est valide (entier positif)
        isset($_POST["duree"]) && is_numeric($_POST["duree"]) && intval($_POST["duree"]) > 0 &&  // Vérifie que la durée est valide (entier positif)
        isset($_POST["idEntreprise"]) && is_numeric($_POST["idEntreprise"]) && intval($_POST["idEntreprise"]) >= 0  // Vérifie que l'id de l'entreprise est valide (entier positif)
    ) {
        $titre = $_POST["titre"];
        $numeroRue = $_POST["numeroRue"];
        $rue = $_POST["rue"];
        $ville = $_POST["ville"];
        $codePostal = $_POST["codePostal"];
        $duree = $_POST["duree"];
        $remuneration = $_POST["remuneration"];
        $mineure = $_POST["mineure"];
        $places = $_POST["place"];
        $urlImage = $_POST["URL"];
        $competences = $_POST["competences"];
        $description = $_POST["description"];
        $idEntreprise = intval($_POST["idEntreprise"]);
        
        $idOffre = creerOffre(
            $titre,
            $description,
            $competences,
            $remuneration,
            $places,
            $duree,
            $mineure,
            $urlImage,
            new DateTime(),
            $idEntreprise,
            $numeroRue,
            $rue,
            $ville,
            $codePostal
        );

        if (!is_null($idOffre)) {  // Offre créée
            redirectionInterne("offre/liste");  // Redirection vers la liste des offres
        } else {  // Erreur lors de la création de l'offre
            redirectionInterne("offre/creer");  // Redirection vers la page de création d'offre
        }
    } else {
        // if (DEBUG) var_dump($_POST);  // Affiche les données du formulaire pour voir les erreurs
        $entreprises = getEntreprises(true);  // Récupère les entreprises visibles pour les afficher dans le formulaire

        require_once "vue/php/offre/creer_offre_vue.php";
    }
}

function afficherModifierOffre(array $params) {
}

function afficherSupprimerOffre(array $params) {
}
