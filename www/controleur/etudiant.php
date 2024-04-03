<?php
require_once "config.php";
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

    require_once "vue/php/etudiant/liste_etudiants.php";
}



function afficherLectureEtudiant(array $params) {
    if (count($params) != 2 || !is_numeric($params[1]) || intval($params[1]) < 0) {
        header("Location: " . ADRESSE_SITE . "/etudiant/liste");
    }

    $idEtudiant = intval($params[1]);
    $etudiant = getEtudiants($idEtudiant);

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
        isset($_POST) && isset($_POST["nom"]) && isset($_POST["nom"]) &&
        isset($_POST["prenom"]) && isset($_POST["prnom"]) &&
        isset($_POST["email"]) && isset($_POST["email"]) &&
        isset($_POST["hash_mdp"]) && is_numeric($_POST["hash_mdp"]) && 
        isset($_POST["idEtudiant"]) && is_numeric($_POST["idEtudiant"]) && intval($_POST["idEtudiant"]) >= 0  // Vérifie que l'id de l'entreprise est valide (entier positif)
    ) {
        $nom = $_POST["nom"];
        $prenom = $_POST["prenom"];
        $email = $_POST["email"];
        $hash_mdp = $_POST["hash_mdp"];
        
        $idEtudiant = creerEtudiant(
            $nom,
            $prenom,
            $email,
            $hash_mdp
        );

        if (!is_null($idEtudiant)) {  // Etudiant crée
            header("Location: " . ADRESSE_SITE . "/etudiant/liste");  // Redirection vers la liste des étudiants
        } else {  // Erreur lors de la création de l'étudiant
            header("Location: " . ADRESSE_SITE . "/etudiant/creer");  // Redirection vers la page de création d'étudiant
        }
    } else {
        // if (DEBUG) var_dump($_POST);  // Affiche les données du formulaire pour voir les erreurs
        $entreprises = getEntreprises(false);  // Récupère les entreprises visibles pour les afficher dans le formulaire

        require_once "vue/php/etudiant/creer_etudiant_vue.php";
    }
}



function afficherModifierEtudiant(array $params) {
    if (count($params) > 1) {
        if (count($params) != 2 || !is_numeric($params[1]) || $params[1] < 0) {
            header("Location: " . ADRESSE_SITE . "/etudiant/liste");
        }
    }

    $etudiants = modifierEtudiant();
    
    require_once "vue/php/etudiant/liste_etudiants.php";
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
            redirectionErreur(409, "Impossible-de-supprimer-l'étudiant");  // Erreur 409 (Conflit)
        }
    } else {  // Demande de confirmation de suppression
        $etudiant = getEtudiants($idEtudiant);

        if (is_null($etudiant)) {
            redirectionErreur(404);  // Erreur 404 (Non trouvé)
        }
        require_once "vue/php/offre/supprimer_offre_vue.php";
    }
}
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

    require_once "vue/php/etudiant/liste_etudiants.php";
}



function afficherLectureEtudiant(array $params) {
    if (count($params) != 2 || !is_numeric($params[1]) || intval($params[1]) < 0) {
        header("Location: " . ADRESSE_SITE . "/etudiant/liste");
    }

    $idEtudiant = intval($params[1]);
    $etudiant = getEtudiants($idEtudiant);

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
        isset($_POST) && isset($_POST["nom"]) && isset($_POST["nom"]) &&
        isset($_POST["prenom"]) && isset($_POST["prnom"]) &&
        isset($_POST["email"]) && isset($_POST["email"]) &&
        isset($_POST["hash_mdp"]) && is_numeric($_POST["hash_mdp"]) && 
        isset($_POST["idEtudiant"]) && is_numeric($_POST["idEtudiant"]) && intval($_POST["idEtudiant"]) >= 0  // Vérifie que l'id de l'entreprise est valide (entier positif)
    ) {
        $nom = $_POST["nom"];
        $prenom = $_POST["prenom"];
        $email = $_POST["email"];
        $hash_mdp = $_POST["hash_mdp"];
        
        $idEtudiant = creerEtudiant(
            $nom,
            $prenom,
            $email,
            $hash_mdp
        );

        if (!is_null($idEtudiant)) {  // Etudiant crée
            header("Location: " . ADRESSE_SITE . "/etudiant/liste");  // Redirection vers la liste des étudiants
        } else {  // Erreur lors de la création de l'étudiant
            header("Location: " . ADRESSE_SITE . "/etudiant/creer");  // Redirection vers la page de création d'étudiant
        }
    } else {
        // if (DEBUG) var_dump($_POST);  // Affiche les données du formulaire pour voir les erreurs
        $entreprises = getEntreprises(false);  // Récupère les entreprises visibles pour les afficher dans le formulaire

        require_once "vue/php/etudiant/creer_etudiant_vue.php";
    }
}



function afficherModifierEtudiant(array $params) {
    if (count($params) > 1) {
        if (count($params) != 2 || !is_numeric($params[1]) || $params[1] < 0) {
            header("Location: " . ADRESSE_SITE . "/etudiant/liste");
        }
    }

    $etudiants = modifierEtudiant();
    
    require_once "vue/php/etudiant/liste_etudiants.php";
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
            redirectionErreur(409, "Impossible-de-supprimer-l'étudiant");  // Erreur 409 (Conflit)
        }
    } else {  // Demande de confirmation de suppression
        $etudiant = getEtudiants($idEtudiant);

        if (is_null($etudiant)) {
            redirectionErreur(404);  // Erreur 404 (Non trouvé)
        }
        require_once "vue/php/offre/supprimer_offre_vue.php";
    }
}