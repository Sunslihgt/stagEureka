<?php
require_once "outils.php";
require_once "modele/etudiant_modele.php";

// var_dump($params);

// Si pas de paramètre, on redirige vers la liste des étudiants
if (count($params) == 0 || $params[0] == "") {
    redirectionInterne("etudiant/liste");
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
        redirectionInterne("retudiant/liste");
        exit();
    }

    // if (DEBUG) var_dump($_POST);
    // if (DEBUG) echo "<br>";

    if (isset($_POST)) {
        $nom = isset($_POST["nom"]) ? $_POST["nom"] : "";
        $prenom = isset($_POST["prenom"]) ? $_POST["prenom"] : "";
        $ville = isset($_POST["ville"]) ? $_POST["ville"] : "";
        $nomClasse = isset($_POST["nomClasse"]) ? $_POST["nomClasse"] : "";

        $etudiants = getEtudiantsFiltres($nom, $prenom, $ville, $nomClasse);

        require_once "vue/php/etudiant/liste_etudiants_vue.php";
    } else {
        $etudiants = getEtudiants();

        require_once "vue/php/etudiant/liste_etudiants_vue.php";
    }
}



function afficherLectureEtudiant(array $params) {
    if (count($params) != 2 || !is_numeric($params[1]) || intval($params[1]) < 0) {
        redirectionInterne("etudiant/liste");
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
        redirectionInterne("etudiant/liste");
    }

    // if (DEBUG) var_dump($_POST);
    // Filtre massif pour s'assurer que toutes les données sont présentes et valides
    if (
        isset($_POST) && isset($_POST["nom"]) &&
        isset($_POST["prenom"]) &&
        isset($_POST["email"]) &&
        isset($_POST["mdp"]) && strlen($_POST["mdp"]) >= 4 &&
        isset($_POST["idClasse"]) && is_numeric($_POST["idClasse"]) && intval($_POST["idClasse"]) >= 0  // Vérifie que l'id de l'étudiant est valide (entier positif)
    ) {
        $nom = $_POST["nom"];
        $prenom = $_POST["prenom"];
        $mdp = $_POST["mdp"];
        $email = $_POST["email"];
        $idClass = $_POST["idClasse"];

        $idEtudiant = creerEtudiant(
            $nom,
            $prenom,
            $mdp,
            $email,
            $idClass
        );

        if (!is_null($idEtudiant)) {  // Etudiant crée
            redirectionInterne("etudiant/liste");  // Redirection vers la liste des étudiants
        } else {  // Erreur lors de la création de l'étudiant
            redirectionInterne("etudiant/creer");  // Redirection vers la page de création d'étudiant
        }
    } else {
        $classes = getClasses();

        require_once "vue/php/etudiant/creer_etudiant_vue.php";
    }
}



function afficherModifierEtudiant(array $params) {
    if (count($params) != 2 || !is_numeric($params[1]) || $params[1] < 0) {
        redirectionInterne("etudiant/liste");
        exit();
    }

    $idEtudiant = $params[1];

    // if (DEBUG) var_dump($_POST);
    if (
        isset($_POST) && isset($_POST["nom"]) && isset($_POST["prenom"]) && isset($_POST["email"]) && isset($_POST["mdp"]) &&
        isset($_POST["idClasse"]) && is_numeric($_POST["idClasse"]) && intval($_POST["idClasse"]) >= 0
    ) {
        $nom = $_POST["nom"];
        $prenom = $_POST["prenom"];
        $email = $_POST["email"];
        $mdp = $_POST["mdp"];
        $idClasse = $_POST["idClasse"];

        $etudiantsModifie = modifierEtudiant(
            $idEtudiant,
            $nom,
            $prenom,
            $email,
            $mdp,
            $idClasse
        );

        if ($etudiantsModifie) {
            redirectionInterne("etudiant/liste");
        } else {
            redirectionInterne("etudiant/modifier/$idEtudiant");
        }
    } else {
        $etudiant = getEtudiant($idEtudiant);
        $classes = getClasses();

        require_once "vue/php/etudiant/modifier_etudiant_vue.php";
    }
}



function afficherSupprimerEtudiant(array $params) {
    if (count($params) != 2 || !is_numeric($params[1]) || $params[1] < 0) {
        redirectionInterne("etudiant/liste");
    }

    $idEtudiant = $params[1];

    if (isset($_POST) && isset($_POST["confirmation"]) && $_POST["confirmation"] == "oui") {  // Suppression confirmée
        $etudiantSupprime = supprimerEtudiant($idEtudiant);
        if ($etudiantSupprime) {
            redirectionInterne("etudiant/liste");
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
