<?php
require_once "outils.php";
require_once "modele/etudiant_modele.php";

// var_dump($params);

// Si pas de paramètre, on redirige vers la liste des étudiants
if (count($params) == 0 || $params[0] == "") {
    header("Location: " . ADRESSE_SITE . "/etudiant/liste");
    exit();
}

$action = $params[0];
switch ($action) {
    case "liste":
        afficherListeEtudiants($params);
        break;
    case "lire":
        afficherLectureEtudiant($params);
        break;
    case "creer":
        afficherCreerEtudiant($params);
        break;
    case "modifier":
        afficherModifierEtudiant($params);
        break;
    case "supprimer":
        afficherSupprimerEtudiant($params);
        break;
}



function afficherListeEtudiants(array $params) {
    if (count($params) > 1) {
        header("Location: " . ADRESSE_SITE . "/etudiant/liste");
    }

    $etudiants = getEtudiants();

    require_once "vue/php/etudiant/liste_etudiants_vue.php";
}



function afficherLectureEtudiant(array $params) {
    if (count($params) != 2 || !is_numeric($params[1]) || intval($params[1]) < 0) {
        header("Location: " . ADRESSE_SITE . "/etudiant/liste");
    }

    $idEtudiant = intval($params[1]);
    $etudiant = getEtudiant($idEtudiant);

    if (is_null($etudiant)) {
        redirectionErreur(404);  // Erreur 404 (Non trouvé)
    }

    require_once "vue/php/etudiant/lire_etudiant_vue.php";
}



function afficherCreerEtudiant(array $params) {
    if (count($params) > 1) {
        header("Location: " . ADRESSE_SITE . "/etudiant/liste");
    }

    // if (DEBUG) var_dump($_POST);
    // Filtre massif pour s'assurer que toutes les données sont présentes et valides
    if (
        isset($_POST) && isset($_POST["nom"]) &&
        isset($_POST["prenom"]) &&
        isset($_POST["email"]) &&
        isset($_POST["mdp"])
        // isset($_POST["idClass"]) && is_numeric($_POST["idClass"]) && intval($_POST["idClass"]) >= 0  // Vérifie que l'id de l'étudiant est valide (entier positif)
    ) {
        $nom = $_POST["nom"];
        $prenom = $_POST["prenom"];
        $mdp = $_POST["mdp"];
        $email = $_POST["email"];
        // $idClass = $_POST["idClass"];
        $idClass = 1;  // FIXME: recuperer id classe

        $idEtudiant = creerEtudiant(
            $nom,
            $prenom,
            $mdp,
            $email,
            $idClass
        );

        if (!is_null($idEtudiant)) {  // Etudiant crée
            header("Location: " . ADRESSE_SITE . "/etudiant/liste");  // Redirection vers la liste des étudiants
        } else {  // Erreur lors de la création de l'étudiant
            header("Location: " . ADRESSE_SITE . "/etudiant/creer");  // Redirection vers la page de création d'étudiant
        }
    } else {

        require_once "vue/php/etudiant/creer_etudiant_vue.php";
    }
}



function afficherModifierEtudiant(array $params) {
    if (count($params) != 2 || !is_numeric($params[1]) || $params[1] < 0) {
        header("Location: " . ADRESSE_SITE . "/etudiant/liste");
        exit();
    }

    $idEtudiant = $params[1];

    if (DEBUG) var_dump($_POST);
    if (isset($_POST) && isset($_POST["nom"]) && isset($_POST["prenom"]) && isset($_POST["email"]) && isset($_POST["mdp"])) {
        $nom = $_POST["nom"];
        $prenom = $_POST["prenom"];
        $email = $_POST["email"];
        $mdp = $_POST["mdp"];

        $etudiantsModifie = modifierEtudiant(
            $idEtudiant,
            $nom,
            $prenom,
            $email,
            $mdp
        );

        if($etudiantsModifie) {
            header("Location: " . ADRESSE_SITE . "/etudiant/liste");
        } else {
            header("Location: " . ADRESSE_SITE . "/etudiant/modifier/$idEtudiant");
        }
    } else {
        $etudiant = getEtudiant($idEtudiant);

        require_once "vue/php/etudiant/modifier_etudiant_vue.php";
    }
}



function afficherSupprimerEtudiant(array $params) {
    if (count($params) != 2 || !is_numeric($params[1]) || $params[1] < 0) {
        header("Location: " . ADRESSE_SITE . "/etudiant/liste");
    }

    $idEtudiant = $params[1];

    if (isset($_POST) && isset($_POST["confirmation"]) && $_POST["confirmation"] == "oui") {  // Suppression confirmée
        $etudiantSupprime = supprimerEtudiant($idEtudiant);
        if ($etudiantSupprime) {
            header("Location: " . ADRESSE_SITE . "/etudiant/liste");
        } else {  // Erreur lors de la suppression de l'étudiant
            redirectionErreur(409, "Impossible-de-supprimer-l'étudiant-(un-étudiant-qui-a-des-wishlists-ou-candidatures-n'est-pas-supprimable)");  // Erreur 409 (Conflit)
        }
    } else {  // Demande de confirmation de suppression
        $etudiant = getEtudiant($idEtudiant);

        if (is_null($etudiant)) {
            redirectionErreur(404);  // Erreur 404 (Non trouvé)
        }
        require_once "vue/php/etudiant/supprimer_etudiant_vue.php";
    }
}
