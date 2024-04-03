<?php
require_once "config.php";
require_once "modele/pilote_modele.php";

// var_dump($params);

if (count($params) == 0 || $params[0] == "") {
    header("Location: " . ADRESSE_SITE . "/pilote/liste");
    exit();
}

$action = $params[0];
switch ($action) {
    case "liste":
        afficherListePilote($params);
        break;
    case "lire":
        // afficherLecturePilote($params);
        break;
    case "creer":
        afficherCreerPilote($params);
        break;
    case "modifier":
        afficherModifierPilote($params);
        break;
    case "supprimer":
        afficherSupprimerPilote($params);
        break;
    default:
        header("Location: " . ADRESSE_SITE . "/pilote/liste");
        break;
}

// function afficherLecturePilote(array $params) {
//     if (count($params) != 2 || !is_numeric($params[1]) || intval($params[1]) < 0) {
//         header("Location: " . ADRESSE_SITE . "/pilote/liste");
//     }

//     $idPilote = intval($params[1]);
//     $pilote = getPilotes($idPilote);

//     if (is_null($pilote)) {
//         redirectionErreur(404);  // Erreur 404 (Non trouvé)
//     }

//     require_once "vue/php/etudiant/lire_pilote_vue.php";
// }

function afficherListePilote(array $params)
{
    if (count($params) > 1) {
        header("Location: " . ADRESSE_SITE . "/pilote/liste");
    }

    $pilotes = getPilotes();

    // var_dump($pilotes);

    require_once "vue/php/pilote/liste_pilotes_vue.php";
}

function afficherCreerPilote(array $params)
{
    if (count($params) > 1) {
        header("Location: " . ADRESSE_SITE . "/pilote/liste");
        exit();
    }

    if (isset($_POST) && isset($_POST["nom-pilote"]) && isset($_POST["prenom-pilote"]) && isset($_POST["email-pilote"]) && isset($_POST["mdp-pilote"])) {
        $nom = $_POST["nom-pilote"];
        $prenom = $_POST["prenom-pilote"];
        $email = $_POST["email-pilote"];
        $mdp = $_POST["mdp-pilote"];

        $idPilote = creerPilote($nom, $prenom, $email, $mdp);

        if (!is_null($idPilote)) {
            header("Location: " . ADRESSE_SITE . "/pilote/liste");
        } else {  // Erreur lors de la création
            header("Location: " . ADRESSE_SITE . "/pilote/creer");
        } 
    } else {
        require_once "vue/php/pilote/creer_pilote_vue.php";
    }
}

function afficherModifierPilote(array $params)
{
    if (count($params) != 2 || !is_numeric($params[1]) || $params[1] < 0) {
        header("Location: " . ADRESSE_SITE . "/pilote/liste");
        exit();
    }

    $idPilote = $params[1];
    // $idPilote = intval($params[1]);
    // if (DEBUG) echo var_dump($idPilote) . "<br>";

    // if (DEBUG) echo var_dump($_POST) . "<br>";
    if (isset($_POST) && isset($_POST["nom-pilote"]) && isset($_POST["prenom-pilote"]) && isset($_POST["email-pilote"]) && isset($_POST["mdp-pilote"])) {
        $nom = $_POST["nom-pilote"];
        $prenom = $_POST["prenom-pilote"];
        $email = $_POST["email-pilote"];
        $mdp = $_POST["mdp-pilote"];
        // $classes = $_POST["classes-pilote"];

        // $piloteModifiee = modifierPilote($idPilote, $nom, $prenom, $email, $mdp, $classes );
        $piloteModifiee = modifierPilote($idPilote, $nom, $prenom, $email, $mdp);

        // if (DEBUG) echo "pilote modifiée: " . var_dump($piloteModifiee) . "<br>";

        if ($piloteModifiee) {  // pilote modifiée
            header("Location: " . ADRESSE_SITE . "/pilote/liste");
            // redirectionInterne("pilote/liste"); Redirection vers la liste des pilotes
        } else {  // Erreur lors de la modification de l'pilote
            header("Location: " . ADRESSE_SITE . "/pilote/modifier");
            // redirectionInterne("pilote/modifier"); Redirection vers la page de modification d'pilote
        }
    } else {
        $pilote = getPilote($idPilote);

        if (is_null($pilote)) {
            redirectionErreur(404);  // Erreur 404 (Non trouvé)
        }
        require_once "vue/php/pilote/modifier_pilote_vue.php";
    }
}

function afficherSupprimerPilote(array $params)
{
    if (count($params) != 2 || !is_numeric($params[1]) || $params[1] < 0) {
        header("Location: " . ADRESSE_SITE . "/pilote/liste");
        exit();
    }

    $idPilote = $params[1];

    if (isset($_POST) && isset($_POST["confirmation"]) && $_POST["confirmation"] == "oui") {  // Suppression confirmée
        $piloteSupprimee = supprimerPilote($idPilote);

        if ($piloteSupprimee) {
            header("Location: " . ADRESSE_SITE . "/pilote/liste");
        } else {  // Erreur lors de la suppression du pilote
            // La suppression échouera si le pilote est liée à des offres, des notes...
            redirectionErreur(409, "Impossible-de-supprimer-le-pilote-(essayez-de-la-cacher)");  // Erreur 409 (Conflit)
        }
    } else {  // Demande de confirmation de suppression
        $pilote = getPilote($idPilote);

        if (is_null($pilote)) {
            redirectionErreur(404);  // Erreur 404 (Non trouvé)
        }

        require_once "vue/php/pilote/supprimer_pilote_vue.php";
    }
}
